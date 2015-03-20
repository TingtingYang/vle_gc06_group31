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
           aside {
                width: 350;
                float: left;
                margin-top: 1em;
               font-family: "Times New Roman", Times, serif;
            }
            article {
                width:65%;
                float: right;
                backfround: orange;
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
            .receivedComments table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .receivedComments th, td {
                padding: 15px;
            }
            .receivedComments th {
                font-style: bold;
            }
            .receivedComments tr:nth-child(even) {
                background-color: #eee;
            }
            .receivedComments tr:nth-child(odd) {
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
                    <li><a href="StudentForum.php" title="Group Forum Page">Forum</a></li>
                    <li id="current"><a href="StudentAssessment.php" title="Student Assessment Page">Assessment</a></li>
                    <li><a href="StudentReview.php" title="Student Review Page">Review</a></li>
                </ul>
        </nav>
        <aside role="aside">
            <div class="container">
                <p align="left"><img src="image/groupAssessment.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <?php $sql="SELECT title FROM report WHERE groupNo='{$currentStudent['groupNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php $resultTitle=$result->fetch_assoc(); ?>
                    
                    <?php $sql="SELECT totalGrade,groupNo FROM assessment WHERE groupNo='{$currentStudent['groupNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php $resultGrade=$result->fetch_assoc(); ?>
                    
                    <?php $ranking=1; ?>
                    <?php $sql="SELECT groupNo,totalGrade FROM assessment ORDER BY totalGrade DESC"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php while($resultRank = $result->fetch_assoc()){ ?>
                    <?php if(($resultGrade['groupNo'])!=($resultRank['groupNo'])) { ?>
                    <?php if(($resultGrade['totalGrade'])<($resultRank['totalGrade'])) { ?>
                    <?php $ranking=$ranking+1; ?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    
                    <p style="color:#7e7979;">This is the final grade for your group.</p>
                    <p style="font-size:20px;text-align:center;"><b>Group&nbsp;<?PHP echo $currentStudent['groupNo']; ?></b></p><br>
                    <p style="font-size:20px;">Report Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $resultTitle['title']; ?></p><br>
                    <p style="font-size:20px;">Group Grade:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $resultGrade['totalGrade']; ?>/200</p><br>
                    <p style="font-size:20px;">Ranking:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ranking; ?>/20</p>
                </div>
            </div>
        </aside>
        <article role="article">
            <div class="container">
                <p align="left"><img src="image/receivedComments.jpg" alt="" width="700" height="40" />
                <div class="subContainer">
                    <?php $sql="SELECT grade1,grade2,comment1,comment2 FROM assessment WHERE groupNo='{$currentStudent['groupNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <table style="width:100%;text-align:center;" class="receivedComments">
                        <tr>
                            <th>No</th>
                            <th>Comments</th>		
                            <th>Grade</th>
                        </tr>
                        <?php while($row=$result->fetch_assoc()) { ?>
                        <tr>
                            <td>1</td>
                            <td><?php echo $row['comment1']; ?></td>		
                            <td><?php echo $row['grade1']; ?>/100</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><?php echo $row['comment2']; ?></td>		
                            <td><?php echo $row['grade2']; ?>/100</td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="container">
                <p align="left"><img src="image/CheckOtherGroup.jpg" alt="" width="700" height="40" />
                <div class="subContainer">
                    <?php $sql="SELECT assessedGroup1,assessedGroup2 FROM assessment WHERE groupNo='{$currentStudent['groupNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php $row=$result->fetch_assoc(); ?>
                    <?php $sql="SELECT totalGrade FROM assessment WHERE groupNo='{$row['assessedGroup1']}'"; ?>
                    <?php $resultGrade1 = $db->query($sql); ?>
                    <?php $row1=$resultGrade1->fetch_assoc(); ?>
                    <?php $sql="SELECT totalGrade FROM assessment WHERE groupNo='{$row['assessedGroup2']}'"; ?>
                    <?php $resultGrade2 = $db->query($sql); ?>
                    <?php $row2=$resultGrade2->fetch_assoc(); ?>
                    <table style="width:100%;text-align:center;" class="receivedComments">
                        <tr>
                            <th>Assessed By Group</th>	
                            <th>Grade</th>
                        </tr>
                        <tr>
                            <td><?php echo $row['assessedGroup1']; ?></td>		
                            <td><?php echo $row1['totalGrade']; ?>/200</td>
                        </tr>
                        <tr>
                            <td><?php echo $row['assessedGroup2']; ?></td>		
                            <td><?php echo $row2['totalGrade']; ?>/200</td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php $db->close();?>
        </article>
        <footer>
        </footer>
    </body>
</html>