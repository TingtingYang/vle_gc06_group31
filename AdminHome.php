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
        <meta name="description" content="A home page for administrator">
        <title>Administrator Home Page</title>
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
            #admin_Assigned table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            #admin_Assigned th, td {
                padding: 15px;
            }
            #admin_Assigned th {
                font-style: bold;
            }
            #admin_Assigned tr:nth-child(even) {
                background-color: #eee;
            }
            #admin_Assigned tr:nth-child(odd) {
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
                    <li id="current"><a href="AdminHome.php" title="Admin Home Page">Home</a></li>
                    <li><a href="AdminManagement.php" title="Admin Management Page">Management</a></li>
                    <li><a href="AdminAssessment.php" title="Admin Assessment Page">Assessment</a></li>
                </ul>
        </nav>
        <aside role="aside">
            <div class="container">
                <p align="left"><img src="image/LoggedIn.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <?php $sql="SELECT name,email FROM administrator WHERE adminNo='{$currentAdmin['adminNo']}'"; ?>
                    <?php $result = $db->query($sql); ?>
                    <?php $row=$result->fetch_assoc(); ?>
                    <p style="text-align: center;">
                        <img src="image/photo.jpg" alt="" width="239" height="187" /></p>
			        <p>Full Name:&nbsp;&nbsp;&nbsp;<?php echo $row['name']; ?></p>
			        <p>Email Address:&nbsp;&nbsp;&nbsp;<?php echo $row['email']; ?></p>
                </div>
            </div>
            <div class="container">
                <p align="left"><img src="image/news.jpg" alt="" width="350" height="40" />
                <div class="subContainer">
                    <?php $sql = "SELECT studentNo,name FROM student WHERE status = 0";?> 
                    <?php $result = $db->query($sql); ?>
                    <?php if($db->error){
                                $message = $db->error;
                    } ?>
                    <?php if($message){ ?><p><?php echo "$message"; ?></p>
                    <?php }else { ?>
                        <?php if ($result->num_rows > 0) { ?>
                                <?php while($row=$result->fetch_assoc()) { ?>
                                <p><?php echo "New User&nbsp". ":". $row['studentNo']. "&nbspName:". $row['name']; ?></p>
                                <?php } ?>
                        <?php }else{ ?>
                        <p><?php echo "No new registered users!"; ?>
                        <?php } ?>
                    <?php } ?>
                    <input type="submit" value="Manage" style="width: 30%;" onclick=javascript:jumpTo()>
                </div>
            </div>
        </aside>
        <article role="article">
            <div class="container">
                <p align="left"><img src="image/studentInfo.jpg" alt="" width="700" height="40" />
                <div class="subContainer">
                    <form method="POST">
                        <p>
                            <label for="searchterm">Searched by:</label>
                            <select name="selection">
                                <option value="name">Student Name</option>
                                <option value="studentNo">Student ID</option>
                            </select>
                            <input type="text" name="term">
                            <input type="submit" name="search" value="search"/>
                        </p>
                    </form>
                    <p>Results:</p>
                        <?php if(!empty($_POST['term'])&&isset($_POST['search'])&&isset($_POST['selection'])){ ?>
                            <?php 
                            $sql = "SELECT studentNo,name,gender,email FROM student WHERE {$_POST['selection']} IN ('{$_POST['term']}')";?> 
                            <?php $result = $db->query($sql); ?>
                            <?php if($db->error){
                                  $message = $db->error;
                            } ?>
                            <?php if($message){ ?><textarea style="width: 80%;height: 200px; text-align:left;"><?php echo "$message"; ?></textarea>
                            <?php }else { ?>
                                  <?php if ($result->num_rows > 0) { ?>
                                  <?php while($row=$result->fetch_assoc()) { ?>
                                     <textarea style="width: 80%;height: 100px;font-size:20px;"><?php echo "id: ".  $row["studentNo"]. "&nbspName: " . $row["name"]. "&nbsp Email: " . $row["email"]; ?>
                                     </textarea>
                                 <?php } ?>
                                 <?php } else { ?>
                                     <textarea style="width: 80%;height: 100px; text-align:left;"><?php echo "0 results"; ?>
                                     </textarea>
                                 <?php } ?>
                                 <?php } ?>
                                 <?php $_POST['term']===NULL; ?>
                          <?php }else { ?>
                                 <textarea style="width: 80%;height: 100px; "><?php echo "PLease enter the search term and select the specific item in the list." ?>
                                 </textarea>
                          <?php } ?>
                </div>
            </div>
            <div class="container">
                <p align="left"><img src="image/assignedReport.jpg" alt="" width="700" height="40" />
                <div class="subContainer">
                    <?php $sql = "SELECT COUNT(groupNo) AS count FROM assessment"; ?>
                    <?php $result = $db->query($sql); ?>    
                    <?php $row=$result->fetch_assoc() ?>
                    <table style="width:100%;font-size:20px;border-collapse:collapse;" id="admin_Assigned">
                            <tr>
                                <th>Group No</th>		
                                <th>Status (Reviewed by)</th>
                            </tr>
                    <?php for($i=1;$i<=$row['count'];$i++) { ?>
                    <?php $sql = "SELECT groupNo,grade1,grade2 FROM assessment WHERE groupNo={$i}"; ?>
                    <?php $resultnew = $db->query($sql); ?>
                                  <?php while($rownew=$resultnew->fetch_assoc()) { ?>
                                  <?php if (!empty($rownew['grade1'])&&!empty($rownew['grade2']) ){ ?>
                                        <tr>
                                            <td><?php echo $rownew['groupNo']; ?></td>
                                            <td>2/2</td>
                                        </tr>
                                  <?php }elseif (empty($rownew['grade1'])||empty($rownew['grade2']) ){ ?>
                                        <tr>
                                            <td><?php echo $rownew['groupNo']; ?></td>
                                            <td>1/2</td>
                                        </tr>
                                  <?php }elseif(empty($rownew['grade1'])&&empty($rownew['grade2']) ) { ?>
                                        <tr>
                                            <td><?php echo $rownew['groupNo']; ?></td>
                                            <td>0/2</td>
                                        </tr>
                                  <?php } ?>
                                  <?php } ?>             
                    <?php } ?>
                    </table>
                </div>
            </div>
            <?php $db->close();?>
        </article>
        <footer>
        </footer>
    </body>
    <script type="text/javascript">
        function jumpTo(){
            window.location.href="AdminManagement.php";
        }
    </script>
</html>