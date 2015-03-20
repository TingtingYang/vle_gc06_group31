<?php 
	include_once("configure.php");
?>

<?php if( !(isset( $_POST['login'] ) ) ) { ?>

<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    
    <body>
    
        <header id="head" >
        	<p>Peer Assessment System</p>
        	<p><a href="register.php"><span id="register">Register</span></a></p>
        </header>
        
        <div id="main-wrapper">
        	<div id="login-wrapper">
            	<form method="post" action="">
                	<ul>
                    	<li>
                        	<label for="usn">Email : </label>
                        	<input type="text" maxlength="30" required autofocus name="email" />
                    	</li>
                    
                    	<li>
                        	<label for="passwd">Password : </label>
                        	<input type="password" maxlength="30" required name="password" />
                    	</li>
					
                    	<li class="buttons">
                    	 
                    	
                          <input type="submit" name="login" value="Log me in" />
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
	
	if( $usr->userLogin() ) {
		echo "<script type='text/javascript'>";	
        echo "window.location.href='AdminHome.php'";
        echo "</script>";
	} else {
		echo "Incorrect Email/Password";	
	}
}
?>