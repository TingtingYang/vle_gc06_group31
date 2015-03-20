<?php ini_set('display_errors', 0); ?>
<?php 
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
if(!empty($_FILES)){
if($_FILES["file"]["error"] == 0){
move_uploaded_file($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);
echo $_FILES['file']['name'].'has been successfully uploaded'.'</br>';
}
}

$string=$_FILES['file']['name'];
$xmlDoc = new DOMDocument();
$xmlDoc->load($string);
$years = $xmlDoc->getElementsByTagName("message");
foreach($years as $message){
    

    $titles = $message->getElementsByTagName("title");
    $title = $titles->item(0)->nodeValue;
    
 $holidays = $message->getElementsByTagName("content");
    
    foreach($holidays as $content){
        
        $holidayNames = $content->getElementsByTagName("keyword");
        $keyword = $holidayNames->item(0)->nodeValue;
        
        
        
        $daysOffs = $content->getElementsByTagName("paragraph");
        $paragraph = $daysOffs->item(0);    
        $froms = $paragraph->getElementsByTagName("word");
        $word = $froms->item(0)->nodeValue;
        $tos = $paragraph->getElementsByTagName("conclusion");
        $conclusion = $tos->item(0)->nodeValue;
		echo  $title.'</br>';
		echo  $keyword.'</br>';
        echo  $word.'</br>';
        echo  $conclusion.'</br>';
        
    $query = "SELECT `groupNo`, `,`keywords`,`content`,`conclusion` FROM parsexml WHERE groupNo='{$currentStudent['groupNo']}'";
		$result = $dbLink->query($query);
		if($result->num_row!=1) {
			$query = "
            INSERT INTO `parsexml` (
                `groupNo`,`title`,`keywords`,`content`,`conclusion`
            )
            VALUES (
                '{$currentStudent['groupNo']}','{$title}','{$keyword}','{$word}','{$conclusion}'
            ) ";
			$result = $dbLink->query($query);
		}	if($result->num_row=1)	{
			$query = "
			UPDATE parsexml SET title='{$title}',keywords='{$keyword}',content='{$word}',groupNo='{$currentStudent['groupNo']}',conclusion='{$conclusion}'
           
			WHERE groupNo='{$currentStudent['groupNo']}'";
			$result = $dbLink->query($query);
		}	

       
 
       
 
        // Check if it was successfull
        if($result) {
            echo 'Success! Your data was successfully added!';
        }
        else {
            echo 'Error! Failed conclusion insert the data'
               . "<pre>{$dbLink->error}</pre>";
        }
}}
echo '<p>Click <a href="StudentSubmission.php">here</a> to go back</p>';
?>