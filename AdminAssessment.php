<?php 
   $message = '';
   $db = new MySQLi('localhost','vle','911108','vle_system');
   if($db -> connect_error){
       $message = $db -> connect_error;
   } 
?>
<?php $sql = "SELECT adminNo FROM administrator WHERE state=1";?>
<?php $result = $db->query($sql); ?>
<?php if($db->error){
        $message = $db->error;
} ?>
<?php $currentAdmin=$result->fetch_assoc(); ?>
<?php if($message){ ?><p><?php echo "$message"; ?></p>
<?php } ?>
<?php ini_set('display_errors',0); ?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A page for student assessment">
        <title>Admin Assessment Page</title>
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
                width:72%;
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
            .adminAssessment table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .adminAssessment th, td {
                padding: 15px;
            }
            .adminAssessment th {
                font-style: bold;
            }
            .adminAssessment tr:nth-child(even) {
                background-color: #eee;
            }
            .adminAssessment tr:nth-child(odd) {
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
            <p id="logout">Welcome user <?php echo $currentAdmin['adminNo']; ?>!<a href="logout.php" onclick="return confirm('Are you sure to logout?');">Logout</a></p>
        </header>
        <nav id="navigation" class="navfix">
                <ul>
                    <li><a href="AdminHome.php" title="Admin Home Page">Home</a></li>
                    <li><a href="AdminManagement.php" title="Admin Management Page">Management</a></li>
                    <li id="current"><a href="AdminAssessment.php" title="Admin Assessment Page">Assessment</a></li>
                </ul>
        </nav>
        <article role="article">
            <div class="container">
                <p align="left"><img src="image/groupRanking.jpg" alt="" width="768" height="40" />
                <div class="subContainer">
                    <?php $sql="SELECT groupNo FROM assessment WHERE totalGrade=0"; ?>
                    <?php $result = $db->query($sql); ?>
                        <?php while($row=$result->fetch_assoc()) { ?>
                        <?php $sql="SELECT grade1,grade2 FROM assessment WHERE groupNo='{$row['groupNo']}'"; ?>
                        <?php $resultGroup = $db->query($sql); ?>
                        <?php $resultGrade=$resultGroup->fetch_assoc(); ?>
                    
                        <?php $totalGrade=$resultGrade['grade1']+$resultGrade['grade2']; ?>
                        <?php $sql="UPDATE assessment SET totalGrade='$totalGrade' WHERE groupNo='{$row['groupNo']}'"; ?>
                        <?php $result = $db->query($sql); ?>
                        <?php echo "<script>window.location.href='AdminAssessment.php'</script>"; ?>
                        <?php } ?>
                    
                    <table style="width:100%" class="adminAssessment">
                        <tr>
                            <th>Ranking</th>
                            <th>Group No</th>
                            <th>Grade</th>		
                        </tr>
                        <?php $ranking=1; ?>
                        <?php $sql="SELECT groupNo,totalGrade FROM assessment ORDER BY totalGrade DESC"; ?>
                        <?php $result = $db->query($sql); ?>
                        <?php while($resultRank = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $ranking; ?></td>
                            <td><?php echo $resultRank['groupNo']; ?></td>		
                            <td><?php echo $resultRank['totalGrade']; ?>/200</td>
                        </tr>
                        <?php $ranking=$ranking+1; ?>
                        <?php } ?>

                    </table>
                </div>
            </div>
        <?php $db->close();?>
        </article>
        <footer>
        </footer>
    </body>
</html>