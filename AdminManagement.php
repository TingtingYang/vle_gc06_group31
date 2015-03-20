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
        <meta name="description" content="A Management page for Administrator">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <title>Administrator Management Page</title>
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
            #admin_Management table, th, td {
                text-align: center;
                border: 1px solid black;
                border-collapse: collapse;
            }
            #admin_Management th, td {
                padding: 15px;
            }
            #admin_Management th {
                font-style: bold;
            }
            #admin_Management tr:nth-child(even) {
                background-color: #eee;
            }
            #admin_Management tr:nth-child(odd) {
                background-color:#fff;
            }
            .TableButton {
                float: right;
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
                    <li id="current"><a href="AdminManagement.php" title="Admin Management Page">Management</a></li>
                    <li><a href="AdminAssessment.php" title="Admin Assessment Page">Assessment</a></li>
                </ul>
        </nav>
        <aside role="aside">
            <div class="container">
                <p align="left"><img src="image/studentList.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <form method="POST">
                    <p><label for="searchterm">Searched by:</label></p>
                    <select name="selection">
                       <option value="groupNo">Group No</option>
                       <option value="studentNo">Student ID</option>
                       <option value="allGroup">All defined groups</option>
                       <option value="allStudent">All registered students</option>
                       <option value="newStudent">Not accepted students</option>
                    </select>
                    <input type="text" name="term">
                    <br><br>
                    <input type="submit" name="search" value="search" style="float:right;">
                    <br><br>
                    </form>

                    <?php if($_POST['selection']=== "allStudent"&&isset($_POST['search'])) { ?>
                            <?php $sql = "SELECT s.studentNo,r.groupNo FROM student AS s LEFT JOIN reportteam AS r ON s.studentNo=r.studentNo WHERE s.status=1"; ?> 
                            <?php $result = $db->query($sql); ?>
                            <?php if($db->error){
                                  $message = $db->error;
                            } ?>
                            <?php if($message){ ?><p><?php echo "$message"; ?></p>
                            <?php }else { ?>
                                  <?php if ($result->num_rows > 0) { ?>
                                       <table style="width:100%;" id="admin_Management">
                                         <tr>
                                             <th>Group No</th>
                                             <th>Student ID</th>		
                                         </tr>
                                  <?php while($row=$result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['groupNo']; ?></td>
                                            <td><?php echo $row['studentNo']; ?></td>
                                        </tr>
                                  <?php } ?>
                                        </table>
                                 <?php } else {?>
                                           <p><b>Sorry, no matching results. <br>Please check your search term.</b></p>
                                 <?php } ?>
                             <?php } ?>
                     <?php }elseif($_POST['selection']=== "newStudent"&&isset($_POST['search'])) { ?>
                            <?php $sql = "SELECT studentNo FROM student WHERE status=0"; ?>
                            <?php $result = $db->query($sql); ?>
                            <?php if($db->error){
                                  $message = $db->error;
                            } ?>
                            <?php if($message){ ?><p><?php echo "$message"; ?></p>
                            <?php }else { ?>
                                  <?php if ($result->num_rows > 0) { ?>
                                       <table style="width:100%;" id="admin_Management">
                                         <tr>
                                             <th>Group No</th>
                                             <th>Student ID</th>
                                         </tr>
                                  <?php while($row=$result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['groupNo']; ?></td>
                                            <td><?php echo $row['studentNo']; ?></td>
                                        </tr>
                                  <?php } ?>
                                        </table>
                                 <?php } else {?>
                                           <p><b>Sorry, no matching results. <br>Please check your search term.</b></p>
                                 <?php } ?>
                             <?php } ?>
                      <?php }elseif($_POST['selection']=== "groupNo"&&isset($_POST['search'])&&!empty($_POST['term'])) { ?>
                            <?php $sql = "SELECT studentNo,groupNo FROM reportteam WHERE groupNo={$_POST['term']}"; ?>
                            <?php $result = $db->query($sql); ?>
                            <?php if($db->error){
                                  $message = $db->error;
                            } ?>
                            <?php if($message){ ?><p><?php echo "$message"; ?></p>
                            <?php }else { ?>
                                  <?php if ($result->num_rows > 0) { ?>
                                       <table style="width:100%;" id="admin_Management">
                                         <tr>
                                             <th>Group No</th>
                                             <th>Student ID</th>		
                                         </tr>
                                  <?php while($row=$result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['groupNo']; ?></td>
                                            <td><?php echo $row['studentNo']; ?></td>
                                        </tr>
                                  <?php } ?>
                                        </table>
                                 <?php } else {?>
                                           <p><b>Sorry, no matching results. <br>Group not exists.</b></p>
                                 <?php } ?>
                             <?php } ?>
                      <?php }elseif($_POST['selection']=== "studentNo"&&isset($_POST['search'])&&!empty($_POST['term'])) { ?>
                            <?php $sql = "SELECT studentNo,groupNo FROM reportteam WHERE studentNo=(SELECT studentNo FROM student WHERE studentNo={$_POST['term']})"; ?>
                            <?php $result = $db->query($sql); ?>
                            <?php if($db->error){
                                  $message = $db->error;
                            } ?>
                            <?php if($message){ ?><p><?php echo "$message"; ?></p>
                            <?php }else { ?>
                                  <?php if ($result->num_rows > 0) { ?>
                                       <table style="width:100%;" id="admin_Management">
                                         <tr>
                                             <th>Group No</th>
                                             <th>Student ID</th>		
                                         </tr>
                                  <?php while($row=$result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['groupNo']; ?></td>
                                            <td><?php echo $row['studentNo']; ?></td>
                                        </tr>
                                  <?php } ?>
                                        </table>
                                 <?php } else {?>
                                           <p>This student has no group.</p>
                                 <?php } ?>
                             <?php } ?>
                      <?php }elseif($_POST['selection']==="allGroup"&&isset($_POST['search'])) { ?>
                            <?php $sql = "SELECT studentNo,groupNo FROM reportteam"; ?>
                            <?php $result = $db->query($sql); ?>
                            <?php if($db->error){
                                  $message = $db->error;
                            } ?>
                            <?php if($message){ ?><p><?php echo "$message"; ?></p>
                            <?php }else { ?>
                                  <?php if ($result->num_rows > 0) { ?>
                                       <table style="width:100%;" id="admin_Management">
                                         <tr>
                                             <th>Group No</th>
                                             <th>Student ID</th>		
                                         </tr>
                                  <?php while($row=$result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['groupNo']; ?></td>
                                            <td><?php echo $row['studentNo']; ?></td>
                                        </tr>
                                  <?php } ?>
                                        </table>
                                 <?php } else {?>
                                           <p><b>Sorry, no matching results. <br>No defined groups.</b></p>
                                 <?php } ?>
                             <?php } ?>
                      <?php }?>
                </div>
            </div>
            <div class="container">
                <p align="left"><img src="image/NewUser.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <form method="post" >
                    <p><label for="add new members">Accept student ID:</label>
                    <input type="text" name="newstudent"></p>
                    <input type="submit" value="Confirm" name="submitNewStudent" style="margin-left:280px;">
                    </form>
                    
                    <?php if(isset($_POST['submitNewStudent'])&&!empty($_POST['newstudent'])) { ?>
                    <?php $sql="UPDATE student SET status=1 WHERE studentNo='{$_POST['newstudent']}'"; ?>
                    <?php $result=$db->query($sql); ?>
                    <?php } ?>
                </div>
            </div>
            <div class="container">
                <p align="left"><img src="image/setDeadline.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <form method="post" >
                    <p><label>Deadline for Submitting:</label>
                    <input type="text" name="newDeadlineSub"></p>
                    <p><label>Deadline for Reviewing:</label>
                    <input type="text" name="newDeadlineReview"></p>
                    <input type="submit" value="Set" name="setDeadline" style="margin-left:280px;">
                    </form>
                    
                    <?php if(isset($_POST['setDeadline'])&&!empty($_POST['newDeadlineSub'])&&!empty($_POST['newDeadlineReview'])) { ?>
                    <?php $sql="UPDATE report SET deadlineSub='{$_POST['newDeadlineSub']}',deadlineReview='{$_POST['newDeadlineReview']}'"; ?>
                    <?php $result=$db->query($sql); ?>
                    <?php } ?>
                </div>
            </div>
        </aside>
        <article role="article">
            <div class="container">
                <p align="left"><img src="image/groupManagement.jpg" alt="" width="700" height="40" />
                <div class="subContainer">
                    <form method="post" >
                    <p><label for="add group members">Add student ID:</label>
                    <input type="text" name="newMember">
                    <label for="add group members">to GroupNo:</label>
                    <input type="text" name="groupNumber">
                    <input type="submit" value="Add" onclick=javascript:add(<?php echo $_POST['newMember']; ?>,<?php echo $_POST['groupNumber']; ?>)></p>
                    <p><label for="remove group members">Remove student ID:</label>
                    <input type="text" name="removeMemember">
                        <input type="submit" value="Remove" name="remove" onclick=javascript:remove(<?php echo $_POST['removeMemember']; ?>; ></p>
                    </form>
                </div>
            </div>
            <br><br>
            <div class="container">
                <p align="left"><img src="image/reportManagement.jpg" alt="" width="700" height="40" />
                <div class="subContainer">
                    <?php $sql = "SELECT r.groupNo,r.title,assessedGroup1,assessedGroup2 FROM report AS r JOIN assessment AS a ON r.groupNo=a.groupNo"; ?> 
                    <?php $result = $db->query($sql); ?>
                    <?php if($db->error){
                            $message = $db->error;
                    } ?>
                    <?php if($message){ ?><p><?php echo "$message"; ?></p>
                    <?php }else { ?>
                            <?php if ($result->num_rows > 0) { ?>
                    <table style="width:100%;" id="admin_Management">
                        <tr>
                            <th>Group No</th>
                            <th>Submitted Report</th>
                            <th>Report Assigned to</th>
                        </tr>
                        <?php while($row=$result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['groupNo']; ?></td>
                            <th><?php echo $row['title']; ?></th>
                            <td><?php echo $row['assessedGroup1']; ?>,<?php echo $row['assessedGroup2']; ?></td>
                        </tr>
                        <?php } ?>
                        </table>
                        <?php }?>
                    <?php } ?>
                    
                    <form method="post" >
                    <p><label for="assign report">Assign report from group:</label>&nbsp;&nbsp;<input type="text" name="reportNumber" size="10">&nbsp;to&nbsp;<input type="text" name="groupOne" size="10">&nbsp;and&nbsp;<input type="text" name="groupTwo" size="10"><input type="submit" value="Confirm" style="margin-left:10px;" onclick=javascript:confirm(<?php echo $_POST['reportNumber']; ?>,<?php echo $_POST['groupOne']; ?>,<?php echo $_POST['groupTwo']; ?>)></p>
                    <p><label >Remove assigned groups for group:</label><input type="text" name="removeGroup"><input type="submit" value="Remove Group" style="margin-left:10px;" onclick=javascript:removeAssessGroup(<?php echo $_POST['removeGroup']; ?>)></p>
                    </form>
                </div>
            </div>
        </article>
        <footer>
        </footer>
    </body>
    <script type="text/javascript">
        function remove(<?php echo $_POST['removeMember']; ?>){
            <?php if(empty($_POST['removeMemember'])) { ?>
            <?php }else{ ?>
            <?php $sql = "DELETE FROM reportteam WHERE studentNo='{$_POST['removeMemember']}'"; ?> 
            <?php $result = $db->query($sql); ?>
            <?php if($db->error){
                    $message = $db->error;
            } ?>
            <?php if($message){ ?><p><?php echo "$message"; ?></p>
            <?php } ?>
            <?php } ?>
        }               
        
        function add(<?php echo $_POST['newMember']; ?>,<?php echo $_POST['groupNumber']; ?>){
            <?php if(empty($_POST['newMember'])&&empty($_POST['groupNumber'])) { ?>
            <?php }else{ ?>
             <?php $sql = "INSERT INTO reportteam VALUES ('{$_POST['newMember']}','{$_POST['groupNumber']}')"; ?> 
             <?php $result = $db->query($sql); ?>
             <?php if($db->error){
                    $message = $db->error;
             } ?>
             <?php if($message){ ?><p><?php echo "$message"; ?></p>
             <?php }?>          
            <?php } ?>
        }
        function removeAssessGroup(<?php echo $_POST['removeGroup']; ?>){
            <?php if(empty($_POST['removeGroup'])) { ?>
            <?php }else{ ?>
             <?php $sql = "UPDATE assessment SET assessedGroup1='null',assessedGroup2='null' WHERE groupNo=('{$_POST['removeGroup']}')"; ?> 
             <?php $result = $db->query($sql); ?>
             <?php if($db->error){
                    $message = $db->error;
             } ?>
             <?php if($message){ ?><p><?php echo "$message"; ?></p>
             <?php } ?>
            <?php } ?>
        }
        function confirm(<?php echo $_POST['reportNumber']; ?>,<?php echo $_POST['groupOne']; ?>,<?php echo $_POST['groupTwo']; ?>){
            <?php if(empty($_POST['reportNumber'])&&empty($_POST['groupOne'])&&empty($_POST['groupTwo'])) { ?>
            <?php }else{ ?>
             <?php $sql = "SELECT groupNo FROM assessment WHERE groupNo=('{$_POST['reportNumber']}')"; ?>
             <?php $result = $db->query($sql); ?>
             <?php if($db->error){
                    $message = $db->error;
             } ?>
            <?php if ($result->num_rows > 0) { ?>
             <?php $sql = "UPDATE assessment SET assessedGroup1='{$_POST['groupOne']}',assessedGroup2='{$_POST['groupTwo']}' WHERE groupNo=('{$_POST['reportNumber']}')"; ?> 
             <?php $result = $db->query($sql); ?>
             <?php if($db->error){
                    $message = $db->error;
             } ?>
             <?php if($message){ ?><p><?php echo "$message"; ?></p>
             <?php } ?>
            <?php } else {?>
            <?php $sql = "INSERT INTO assessment(groupNo,assessedGroup1,assessedGroup2) VALUES ('{$_POST['reportNumber']}','{$_POST['groupOne']}','{$_POST['groupTwo']}')"; ?> 
             <?php $result = $db->query($sql); ?>
             <?php if($db->error){
                    $message = $db->error;
             } ?>
             <?php if($message){ ?><p><?php echo "$message"; ?></p>
             <?php } ?>
            <?php } ?>
 
            <?php } ?>
        }
    </script>
    <?php $db->close();?>
</html>