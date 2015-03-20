
<?php ini_set('display_errors', 0); ?><?php 
   $message = '';
   $dbLink = new MySQLi('localhost','vle','911108','vle_system');
   if($dbLink -> connect_error){
       $message = $db -> connect_error;
   } 
?>
<?php $sql = "SELECT s.studentNo,t.groupNo FROM student AS S JOIN reportteam As t WHERE s.state=1 AND s.studentNo=t.studentNo";?>
<?php $result = $dbLink->query($sql); ?>
<?php if($dbLink->error){
        $message = $dbLink->error;
} ?>
<?php $currentStudent=$result->fetch_assoc(); ?>
<?php if($message){ ?><p><?php echo "$message"; ?></p>
<?php } ?>
<?php
// Check if a file has been uploaded
if(isset($_FILES['uploaded_file'])) {
    // Make sure the file was sent without errors
    if($_FILES['uploaded_file']['error'] == 0) {
        // Connect to the database
        $dbLink = new mysqli('localhost','vle','911108','vle_system');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }
 
        // Gather all required data
        $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
        $type = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
        $data = $dbLink->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
        $size = intval($_FILES['uploaded_file']['size']);
       
        // Create the SQL query
        
		$query = "SELECT `type`, `title`, `size`, `data`,`groupNo` FROM report WHERE groupNo='{$currentStudent['groupNo']}'";
		$result = $dbLink->query($query);
		if($result->num_row!=1) {
			$query = "
            INSERT INTO `report` (
                `title`, `type`, `size`, `data`, `groupNo`,`created`
            )
            VALUES (
                '{$name}', '{$type}', '{$size}', '{$data}','{$currentStudent['groupNo']}', NOW()
            ) ";
			$result = $dbLink->query($query);
		}	if($result->num_row=1)	{
			$query = "
			UPDATE report SET title='{$name}',type='{$type}',size='{$size}',data='{$data}',groupNo='{$currentStudent['groupNo']}',created=NOW()
           
			WHERE groupNo='{$currentStudent['groupNo']}'";
			$result = $dbLink->query($query);
		}	
        
 
     
 
        // Check if it was successfull
        if($result) {
            echo 'Success! Your file was successfully added!';
        }
        else {
            echo 'Error! Failed to insert the file'
               . "<pre>{$dbLink->error}</pre>";
        }
    }
    else {
        echo 'An error accured while the file was being uploaded. '
           . 'Error code: '. intval($_FILES['uploaded_file']['error']);
    }
 
    // Close the mysql connection
    $dbLink->close();
}
else {
    echo 'Error! A file was not sent!';
}
 
// Echo a link back to the main page
echo '<p>Click <a href="StudentSubmission.php">here</a> to go back</p>';
?>