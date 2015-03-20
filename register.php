<?php 
	include_once("config.php");
?>

<?php if( !(isset( $_POST['register'] ) ) ) { ?>


<!DOCTYPE html>
<html>
    <head>
        <title>register</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    
    <body>
        <header id="head" >
        	<p>Peer Assessment System</p>
        	<p><a href="register.php"><span id="register">Register</span></a></p>
        </header>
        
        <div id="main-wrapper">
        	<div id="register-wrapper">
            	<form method="post">
                	<ul>
                    	<li>
                        	<label for="usn">Name : </label>
                        	<input type="text" id="usn" maxlength="30" required autofocus name="name" />
                    	</li>
						
						<li>
                        	<label for="emil">Email: </label>
                        	<input type="text" id="emil" maxlength="30" required autofocus name="email" />
							
     
                        </li>
						<li>
                        	<label for="gend">Gender(F/M): </label>
                        	<input type="text" id="gend" maxlength="30" required autofocus name="gender" />
                    	</li>
                    
                    	<li>
                        	<label for="passwd">Password : </label>
                        	<input type="password" id="passwd" maxlength="30" required name="password" />
                    	</li>
                        
                        <li>
                        	<label for="conpasswd">Confirm Password : </label>
                        	<input type="password" id="conpasswd" maxlength="30" required name="conpassword" />
                    	</li>
                    	<li class="buttons">
                        	<input type="submit" name="register" value="Register" />
                            <input type="button" name="cancel" value="Cancel" onclick="location.href='login.php'" />
                    	</li>
                    
                	</ul>
            	</form>
            </div>
        </div>
    
    </body>
</html>

<?php 
} else {
	$usr = new Users;
	$usr->storeFormValues( $_POST );
	
	if( $_POST['password'] == $_POST['conpassword'] ) {
		echo $usr->register($_POST);	
	} else {
		echo "Password and Confirm password not match";	
	}
}
?>
<?php
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
 echo "$email is a valid email address.";
}
else {
 echo "$email is NOT a valid email address.";
}?>