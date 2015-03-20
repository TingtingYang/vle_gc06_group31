<?php
    //set off all error for security purposes
	error_reporting(E_ALL);
	

	//define some contstant
    define( "DB_DSN", "mysql:host=localhost;dbname=vle_system" );
    define( "DB_USERNAME", "vle" );
    define( "DB_PASSWORD", "911108" );
	define( "CLS_PATH", "class" );
	
	//include the classes
	include_once( CLS_PATH . "/Admin.php" );
	

?>