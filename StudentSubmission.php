<?php 
   $message = '';
   $db = new MySQLi('localhost','vle','911108','vle_system');
   if($db -> connect_error){
       $message = $db -> connect_error;
   } 
?>
<?php $sql = "SELECT s.studentNo,t.groupNo FROM student AS S JOIN reportteam As t WHERE s.state=1 AND s.studentNo=t.studentNo";?>
<?php $result = $db->query($sql); ?>
<?php if($db->error){
        $message = $db->error;
} ?>
<?php $currentStudent=$result->fetch_assoc(); ?>
<?php if($message){ ?><p><?php echo "$message"; ?></p>
<?php } ?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A Submission page for student">
        <title>Student Group Submission Page</title>
        <!--<link rel="style sheet" type="text/css" href="style.css">-->
        <style>
            body {
                width: 80%;
                margin: 0 auto;
                background:white;
            }
            header {
                height: 50px;
                margin-bottom: 1em;
                position: relative;
                border-bottom-style: solid;
            }
            #logout {
                position: absolute;
                top: 2px;
                right: 1px;
            }
            #navigation #current a{
                background-color: #ddd;
            }
            #navigation {
                background-color: #eee;
            }
            #navigation ul {
                margin: 0;
                padding: 0; 
            }
            #navigation li {
                border-right: 1px solid #ddd;
                display: block;
                float: left;
                margin: 0;
            }
            #navigation li:last-child {
                border-right-width: 0;
            }
            #navigation a {
                background-color: #eee;
                color: #333;
                display: block;
                padding: .75em 1.5em;
                text-decoration: none;
                transition: all .25s ease-in-out;
            }
            #navigation a:hover {
                background-color: #ddd;
            }
            .navfix:after, 
            .navfix:before {
                content: '';
                display: table;
            }
            .navfix:after {
                clear: both;
            }
            aside {
                width: 350;
                float: left;
                margin-top: 1em;
                font-family: "Times New Roman", Times, serif;
            }
            article {
                width:65%;
                float: right;
                margin-top: 1em;
                font-family: "Times New Roman", Times, serif;
            }
            .container {
                border-style: hidden;
            }
            .subContainer {
                background: white;
                border-style: outset;
                position: relative;
                top: 0px;
                bottom: 1em;
            }
            a:hover {
                color: black;
                text-decoration: none;
            }
            footer {
                clear:both;
                margin-top: 1em;
            }
        </style>
    </head>
    <body>
        <header role="banner">
            <h1>Peer Assessment System</h1>
            <p id="logout">Welcome user <?php echo $currentStudent['studentNo']; ?>!<a href="logout.php" onclick="return confirm('Are you sure to logout?');">Logout</a></p>
        </header>
        <nav id="navigation" class="navfix">
                <ul>
                    <li><a href="StudentHome.php" title="Student Home Page">Home</a></li>
                    <li id="current"><a href="StudentSubmission.php" title="Group Submission Page">Group Submission</a></li>
                    <li><a href="StudentForum.php" title="Student Forum Page">Forum</a></li>
                    <li><a href="StudentAssessment.php" title="Student Assessment Page">Assessment</a></li>
                    <li><a href="StudentReview.php" title="Student Review Page">Review</a></li>
                </ul>
        </nav>
        <aside role="aside">
            <div class="container">
                <p align="left"><img src="image/groupAccount.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <p style="font-size:120%;"><b>Group <?php echo $currentStudent['groupNo']; ?></b></p>
                    <p style="font-size:120%;font-style:Sanserif;">Group Members:</p>
                    <?php $sql="SELECT s.name FROM student AS s JOIN reportteam AS t WHERE groupNo='{$currentStudent['groupNo']}' AND s.studentNo=t.studentNo"; ?>
                    <?php $result = $db->query($sql); ?>
                    <ul>
                        <?php while($row=$result->fetch_assoc()) { ?>
                        <li><?php echo $row['name']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="container">
                <p align="left"><img src="image/reportSubmission.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
					
                         <br> <B>upload report:<B><br>
        <form action="add_file.php" method="post" enctype="multipart/form-data">

                <p><input type="file" name="uploaded_file" value="Select File">
                <input type="submit" value="Upload file"></p>
        </form>
		<form action="parsexml.php" method="post" enctype="multipart/form-data">
        <form enctype="multipart/form-data" action='' method='post'>
        <br> <B>upload report with XML format:<B><br>
            
                <p><input type='file' name='file' />
                <input type='submit' value='Submit' / ></p>
                </div>
            </div>
        </aside>
        <article role="article">
            <div class="container">
                <p align="left"><img src="image/currentVersion.jpg" alt="" width="710" height="40" />
                <div class="subContainer">
          
					<?php

    
// Query for latest existing file

$sql = "SELECT title,type,size,created,groupNo FROM report WHERE groupNo='{$currentStudent['groupNo']}'";
$result = $db->query($sql);
 
// Check if it was successfull
if($result) {
    // Make sure there are some files in there
    if($result->num_rows == 0) {
        echo '<p>There are no files in the database</p>';
    }
    else {
        // Print the top of a table
        echo '<table style="width:100%;border-collapse:collapse;font-size:120%;font-style:Sanserif;">
                <tr>
                    <td><b>Group&nbsp;</b></td>
                    <td><b>Title&nbsp;</b></td>
                    <td><b>Type&nbsp;</b></td>
                    <td><b>Size (bytes)&nbsp;</b></td>
                    <td><b>Created&nbsp;</b></td>
                    <td><b>&nbsp;</b></td>
                </tr>';
 
        // Print each file
        while($row = $result->fetch_assoc()) {
            echo "
                <tr>
                    <td>{$row['groupNo']}&nbsp;</td>
                    <td>{$row['title']}&nbsp;</td>
                    <td>{$row['type']}&nbsp;</td>
                    <td>{$row['size']}&nbsp;</td>
                    <td>{$row['created']}&nbsp;</td>
                    <td><a href='get_file.php?groupNo={$row['groupNo']}'>Download</a></td>
                </tr>";
        }
 
        // Close table
        echo '</table>';
    }
 
    // Free the result
    $result->free();
}
else
{
    echo 'Error! SQL query failed:';
    echo "<pre>{$db->error}</pre>";
}
 
// Close the mysql connection
$db->close();?>
                   
                </div>
            </div>
        </article>
        <footer>
        </footer>
    </body>
</html>