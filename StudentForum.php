<?php ini_set('display_errors', 0); ?>
<?php 
   $message = '';
   $db = new MySQLi('localhost','vle','911108','vle_system');
   if($db -> connect_error){
       $message = $db -> connect_error;
   } 
?>
<?php $sql = "SELECT s.studentNo,t.groupNo,s.name,s.email FROM student AS S JOIN reportteam As t WHERE s.state=1 AND s.studentNo=t.studentNo";?>
<?php $result = $db->query($sql); ?>
<?php if($db->error){
        $message = $db->error;
} ?>
<?php $currentStudent=$result->fetch_assoc(); ?>
<?php if($message){ ?><p><?php echo "$message"; ?></p>
<?php } ?>

<?php

   if($_POST['submit']){
  // Create the SQL query
        $query = "
            INSERT INTO `forum` (
                ID,name,email,title,content,time,groupNo
            )
            VALUES (
               '','{$currentStudent['name']}','{$currentStudent['email']}','$_POST[title]','$_POST[content]',now(),'{$currentStudent['groupNo']}'
            )";
 
        // Execute the query
        $result = $db->query($query);
  
  }
?>


<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A page for student forum">
        <title>Student Group Forum Page</title>
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
                width:65%;
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
                    <li id="current"><a href="StudentForum.php" title="Group Forum Page">Forum</a></li>
                    <li><a href="StudentAssessment.php" title="Student Assessment Page">Assessment</a></li>
                    <li><a href="StudentReview.php" title="Student Review Page">Review</a></li>
                </ul>
        </nav>
        <article role="article">
            <div class="container">
                <p align="left"><img src="image/groupForum.jpg" alt="" width="700" height="40" />
                <div class="subContainer">
                  
                    <form method="POST">
                        <p>
                            <label for="searchterm">Searched by:</label>
                            <select name="selection">
                                <option value="name">Student Name</option>
                                <option value="content">Content</option>
								<option value="title">Title</option>
                            </select>
                            <input type="text" name="term">
                            <input type="submit" name="search" value="search"/>
                        </p>
                    </form>
                    <p>Results:</p>
                        <?php if(!empty($_POST['term'])&&isset($_POST['search'])&&isset($_POST['selection'])){ ?>
                            <?php 
                            $sql = "SELECT name,title,content,time FROM forum WHERE {$_POST['selection']} IN ('{$_POST['term']}')";?> 
                            <?php $result = $db->query($sql); ?>
                            <?php if($db->error){
                                  $message = $dbLink->error;
                            } ?>
                            <?php if($message){ ?><textarea style="width: 80%;height: 200px; text-align:left;"><?php echo "$message"; ?></textarea>
                            <?php }else { ?>
                                  <?php if ($result->num_rows > 0) { ?>
                                  <?php while($row=$result->fetch_assoc()) { ?>
                                     <textarea style="width: 80%;height: 100px;"><?php echo "Name:".  $row["name"].  "&nbsp title: " . $row["title"]. "&nbsp content: " . $row["content"]; ?>
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
        </article>
        <footer>
        </footer>
		<tr>

   <?php

	$con=new MySQLi('localhost','vle','911108','vle_system');
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Perform queries 

		
$pagesize=100;
	$url=$_SERVER["REQUEST_URI"];
	$url=PARSE_URL($url);
	$url=$url[path];		
	$query="select * from forum WHERE groupNo='{$currentStudent['groupNo']}'";
    $result=mysqli_query($con,$query);
	
	$num=mysqli_num_rows($num);				
	if($_GET[page]){
		$pageval=$_GET[page];
		$page=($pageval-1)*$pagesize;
		$page.=',';
	}
	if($num > $pagesize){
 if($pageval<2){
 	$pageval=1;
 }
echo ">> SUM:$num ".
		" <a href=$url?page=".($pageval-1).">Last page</a> <a href=$url?page=".($pageval).">$pageval</a> <a href=$url?page=".($pageval+1).">Next page</a>";
	}
		$sql="select * from forum WHERE groupNo='{$currentStudent['groupNo']}' limit $page $pagesize";
		$que=mysqli_query($con,$sql);
		while($row=mysqli_fetch_array($que)){
?>

<tr>
    <td width="405" class="STYLE1"><b>Name:
    <?php
    echo $row['name'];
    ?></b></td>
</tr><br>
<tr>
    <td width="405" class="STYLE1"><b>Email:
    <?php
    echo $row['email'];
    ?></b></td>
</tr><br>
<tr>
    <td width="385" class="STYLE1" style="font-size:6;"><i>Title:
    <?php
    echo $row['title'];
    ?></i></td>
</tr><br>
<tr>
    <td class="STYLE1">Content:
    <?php
    echo $row['content'];
    ?>
    </td><br>
    <td class="STYLE1"  style="font-size:4;"><i>Time:
    <?php
    echo $row['time'].'<br />';
    ?>
        </i></td>
</tr>
  <tr>
    <td>&nbsp;</td>
    
  </tr>
  <?php
 	}
  ?>

<hr />
<form id="form1" name="form1" method="post" action="">

  <table width="800" border="0" align="center">
    <tr>
      <td width="225" align="right"><span class="STYLE1">Name
      </span>:</td>
      <td width="565"><label>
        <?php echo $currentStudent['name']; ?>
      <span class="STYLE4">        </span></label></td>
    </tr>
    <tr>
      <td align="right"><span class="STYLE1">Title:</span> </td>
      <td><label>
        <input type="text" name="title" id="title" />
      </label></td>
    </tr>
    <tr>
      <td align="right"><span class="STYLE1">Content:</span> </td>
      <td valign="middle"><label>
        <textarea name="content" id="content" cols="45" rows="5"></textarea>
        <span class="STYLE4">*</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><label>
        <input type="submit" name="submit" id="submit" value="Submit" />
      </label></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
        <?php $db->close();?>
</body>
</html>