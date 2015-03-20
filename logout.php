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
<html>
    <body>
        <?php
            session_destroy();
            unset($_SESSION);
            echo "<script>location.href='login.php';</script>";
        ?>
        <?php $sql="UPDATE student SET state=0 WHERE studentNO='{$currentStudent['studentNo']}'"; ?>
        <?php $result = $db->query($sql); ?>
    </body>
    <?php $db->close();?>
</html>