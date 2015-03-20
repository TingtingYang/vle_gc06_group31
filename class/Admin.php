<?php

 class Users {
	 public $name = null;
	 public $password = null;
	  public $email= null;
	  public $gender= null;
	 //public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";
	 
	 public function __construct( $data = array() ) {
		 if( isset( $data['name'] ) ) $this->name = stripslashes( strip_tags( $data['name'] ) );
		 if( isset( $data['email'] ) ) $this->email = stripslashes( strip_tags( $data['email'] ) );
		  if( isset( $data['gender'] ) ) $this->gender = stripslashes( strip_tags( $data['gender'] ) );
		 if( isset( $data['password'] ) ) $this->password = stripslashes( strip_tags( $data['password'] ) );
	 }
	 
	 public function storeFormValues( $params ) {
		//store the parameters
		$this->__construct( $params ); 
	 }
	 
	 public function userLogin() {
		 $success = false;
		 try{
			$con = new PDO( DB_DSN, DB_USERNAME,DB_PASSWORD ); 
			$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$sql = "SELECT * FROM administrator WHERE email = :email AND password = :password AND state=1 LIMIT 1";
			
			$stmt = $con->prepare( $sql );
			$stmt->bindValue( "email", $this->email, PDO::PARAM_STR );
			//$stmt->bindValue( "email", $this->email, PDO::PARAM_STR );
			//$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
			$stmt->bindValue( "password",  $this->password , PDO::PARAM_STR );
		
			$stmt->execute();
			
			
			
			$valid = $stmt->fetchColumn();
			
			if( $valid ) {	
				$success = true;
			}
			$sql = "update administrator set state=1 where email = :email AND password = :password LIMIT 1";
			$stmt = $con->prepare( $sql );
			$stmt->bindValue( "email", $this->email, PDO::PARAM_STR );
			//$stmt->bindValue( "email", $this->email, PDO::PARAM_STR );
			//$stmt->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
			$stmt->bindValue( "password",  $this->password , PDO::PARAM_STR );
		
			$stmt->execute();
			
			$con = null;
			return $success;
		 }catch (PDOException $e) {
			 echo $e->getMessage();
			 return $success;
		 }
 } 
 }
 ?>