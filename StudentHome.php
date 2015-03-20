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
<?php ini_set('display_errors',0); ?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A home page for student">
        <title>Student Home Page</title>
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
                text-align: left;
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
                    <li id="current"><a href="StudentHome.php" title="Student Home Page">Home</a></li>
                    <li><a href="StudentSubmission.php" title="Group Submission Page">Group Submission</a></li>
                    <li><a href="StudentForum.php" title="Student Forum Page">Forum</a></li>
                    <li><a href="StudentAssessment.php" title="Student Assessment Page">Assessment</a></li>
                    <li><a href="StudentReview.php" title="Student Review Page">Review</a></li>
                </ul>
        </nav>
        <aside role="aside">
            <div class="container">
                <p align="left"><img src="image/LoggedIn.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <?php $sql="SELECT name,email FROM student WHERE studentNo='{$currentStudent['studentNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php $row=$result->fetch_assoc(); ?>
                    <p style="text-align: center;">
                        <img src="image/photo.jpg" alt="" width="239" height="187" /></p>
			        <p>Full Name:&nbsp;&nbsp;&nbsp;<?php echo $row['name']; ?></p>
			        <p>Email Address:&nbsp;&nbsp;&nbsp;<?php echo $row['email']; ?></p>
                </div>
            </div>
        </aside>
        <article role="article">
            <div class="container">
                <p align="left"><img src="image/submission.jpg" alt="" width="710" height="40" />
                <div class="subContainer">
                    <?php $sql="SELECT title,created FROM report WHERE groupNo='{$currentStudent['groupNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php $row=$result->fetch_assoc(); ?>
                    
                    <?php $sql2="SELECT deadlineSub FROM report WHERE groupNo=2"; ?>
                        <?php $result2 = $db->query($sql2); ?>
                        <?php $deadline=$result2->fetch_assoc(); ?>
                    <table style="width:100%;border-collapse:collapse;border:none;border-style:none;font-size:120%;font-style:Sanserif;" >
                        <tr>
                            <td>Report Title:</td>
                            <td><?php echo $row['title']; ?></td>
                        </tr>
                        <tr>
                            <td>Submitted at:</td>
                            <td><?php echo $row['created']; ?></td>
                        </tr>
                        <tr>
                            <td>Deadline:</td>
                            <td style="color:red;"><?php echo $deadline['deadlineSub']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Edit Submission" style="float:right;" onclick=javascript:jump()></td>
                        </tr>
                    </table>
                    <?php $db->close();?>
                </div>
            </div>
        </article>
        <footer>
        </footer>
    </body>
    <script type="text/javascript">
        function jump(){
            window.location.href="StudentSubmission.php";
        }
    </script>
</html>