<?php

if(isset($_GET['groupNo'])) {
// Get the GroupNo
    $groupNo = intval($_GET['groupNo']);
 
    // Make sure the GroupNo is in fact a valid GroupNo
    if($groupNo <= 0) {
        die('The GroupNo is invalid!');
    }
    else {
        // Connect to the database
        $dbLink = new mysqli('localhost','vle','911108','vle_system');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }
 
        // Fetch the file information
        $query = "
            SELECT `type`, `title`, `size`, `data`,`groupNo`
            FROM `report`
            WHERE `groupNo` = {$groupNo}";
        $result = $dbLink->query($query);
 
        if($result) {
            // Make sure the result is valid
            if($result->num_rows == 1) {
            // Get the row
                $row = mysqli_fetch_assoc($result);
 
                // Print headers
                header("Content-Type: ". $row['type']);
                header("Content-Length: ". $row['size']);
                header("Content-Disposition: attachment; filename=". $row['title']);
 
                // Print data
                echo $row['data'];
            }
            else {
                echo 'Error! No file exists with that groupNo.';
            }
 
            // Free the mysqli resources
            @mysqli_free_result($result);
        }
        else {
            echo "Error! Query failed: <pre>{$dbLink->error}</pre>";
        }
        @mysqli_close($dbLink);
    }
}
else {
    echo 'Error! No GroupNo was passed.';
}
?>