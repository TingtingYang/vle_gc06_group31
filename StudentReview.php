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
        <meta name="description" content="A page for student assessment">
        <title>Student Assessment Page</title>
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
            article {
                width:80%;
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
            #stu_Review table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            #stu_Review th, td {
                padding: 15px;
            }
            #stu_Review th {
                font-style: bold;
            }
            #stu_Review tr:nth-child(even) {
                background-color: #eee;
            }
            #stu_Review tr:nth-child(odd) {
                background-color:#fff;
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
                    <li><a href="StudentSubmission.php" title="Group Submission Page">Group Submission</a></li>
                    <li><a href="StudentForum.php" title="Student Forum Page">Forum</a></li>
                    <li><a href="StudentAssessment.php" title="Student Assessment Page">Assessment</a></li>
                    <li id="current"><a href="StudentReview.php" title="Student Review Page">Review</a></li>
                </ul>
        </nav>
        <article role="article">
            <?php $sql="SELECT deadlineReview FROM report WHERE groupNo='{$currentStudent['groupNo']}'"; ?>
            <?php $result=$db->query($sql); ?>
            <?php $row=$result->fetch_assoc(); ?>
            <p style="color: red;">Please review the assigned reports before <?php echo $row['deadlineReview']; ?></p>
            <div class="container">
                <p align="left"><img src="image/assignedReport.jpg" alt="" width="870" height="40" />
                <div class="subContainer">                   
                    <?php $sql ="SELECT groupNo FROM assessment WHERE assessedGroup1='{$currentStudent['groupNo']}' OR assessedGroup2='{$currentStudent['groupNo']}'"; ?>
                    <?php $groupResult = $db->query($sql); ?>
                    <?php if($db->error){
                            $message = $db->error;
                    } ?>
                    <?php if($message){ ?><p><?php echo "$message"; ?></p>
                    <?php }else { ?>
                    <table style="width:100%" id="stu_Review">
                        <tr>
                            <th>No</th>	
                            <th>Report Title</th>
                            <th>Grade</th>
                            <th>Comment</th>
                            <th>Status</th>
                        </tr>
                    <?php while($assessingGroup=$groupResult->fetch_assoc()) {?>
                        <?php $sql="SELECT grade1 FROM assessment WHERE groupNo='{$assessingGroup['groupNo']}' AND grade1=0"; ?>
                        <?php $result1 = $db->query($sql); ?>

                        <?php $sql="SELECT grade2 FROM assessment WHERE groupNo='{$assessingGroup['groupNo']}' AND grade2=0"; ?>
                        <?php $result2 = $db->query($sql); ?>
                        
                        <?php $sql="SELECT title FROM report WHERE groupNo='{$assessingGroup['groupNo']}'"; ?>
                        <?php $resultTitle = $db->query($sql); ?>
                        <?php $row=$resultTitle->fetch_assoc(); ?>
                        
                        <form method="post">
                        <tr>
                            <td>Group<?php echo $assessingGroup['groupNo']; ?></td>
                            
                            <td><?php echo $row['title']; ?>
                            <?php echo " <a href='get_file.php?groupNo={$assessingGroup['groupNo']}'>Download</a>";?></td>
                            <?php if(($result1->num_rows===0)&&($result2->num_rows===0)) { ?>
                            <?php $sql="SELECT totalGrade,comment1,comment2 FROM assessment WHERE groupNo='{$assessingGroup['groupNo']}'"; ?>
                            <?php $result = $db->query($sql); ?>
                            <?php $row=$result->fetch_assoc(); ?>
                            <td><?php echo $row['totalGrade']; ?></td>
                            <td><?php echo $row['comment1']; ?>,<?php echo $row['comment2']; ?></td>
                            <td><b>Your group has already reviewed this report.</b></td>
                            <?php }else{ ?>
                            <td><input type="text" name="assessgrade" size="10"></td>
                            <td><input type="text" name="assessComment" size="50"></td>
                            <td><input type="submit" name="submitAssess" value="Submit"></td>
                            <?php } ?>
                        </tr>
                        </form>
                        
                    <?php if(($result1->num_rows>0)&&isset($_POST['submitAssess'])) { ?>
                    <?php $sql="UPDATE assessment SET grade1='{$_POST['assessgrade']}',comment1='{$_POST['assessComment']}' WHERE groupNo='{$assessingGroup['groupNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php }elseif(($result1->num_rows===0)&&($result2->num_rows>0)&&isset($_POST['submitAssess'])) {?>
                    <?php $sql="UPDATE assessment SET grade2='{$_POST['assessgrade']}',comment2='{$_POST['assessComment']}' WHERE groupNo='{$assessingGroup['groupNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php } ?>
                    <?php } ?>
                    </table>
                <?php } ?>
                </div>
            </div>
            <br>
            <br>
           
            
          <?php $db->close();?>  
        </article>
        <footer>
        </footer>
    </body>
</html>