<?php
	include_once 'Session.php';
	include 'Database.php';

class User {
	private $db;
	function __construct(){
		$this->db= new Database();
	}
	public function userRegistration($data){
		$name		=$data['name'];
		$username	=$data['username'];
		$email		=$data['email'];
		$password	=$data['password'];

		$chk_email	=$this->eamilCheck($email);

		if($name=="" or $username=="" or $email=="" or $password==""){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Fild must not be empty</div>";
			return $msg;
		}
		if(strlen($username)<3){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Username is too short</div>";
			return $msg;
		}elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Username must only contain alphanumerical, dashes and usderscores</div>";
			return $msg;
		}elseif(filter_var($email, FILTER_VALIDATE_EMAIL)===false){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Email Address is not valid</div>";
			return $msg;
		}elseif(strlen($password)<6){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Pasword can't be less then Six Character</div>";
			return $msg;
		}

		if ($chk_email==true) {
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Email Address already exist</div>";
			return $msg;
		}
		$password	=md5($data['password']);

		$sql="INSERT INTO tbl_user (name, username, email, password) VALUES(:name, :username, :email, :password)";
		$query= $this->db->pdo->prepare($sql);
		$query->bindValue(':name',$name);
		$query->bindValue(':username',$username);
		$query->bindValue(':email',$email);
		$query->bindValue(':password',$password);
		$result=$query->execute();
		if($result){
			$msg="<div class='alert alert-success'><strong>Success!</strong> You have registerd successfully</div>";
			return $msg;
		}else{
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Data insertion Porblem</div>";
			return $msg;
		}

	}

	public function userLogin($data){
		$email		=$data['email'];
		$password	=$data['password'];
		
		$password	=md5($data['password']);

		$chk_email	=$this->eamilCheck($email);

		if($email=="" or $password==""){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Fild must not be empty</div>";
			return $msg;
		}

		if(filter_var($email, FILTER_VALIDATE_EMAIL)===false){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Email Address is not valid</div>";
			return $msg;
		}

		if ($chk_email==false) {
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Email Address not exist</div>";
			return $msg;
		}	
		$result=$this->getLoginUser($email, $password);
		if($result){
			Session::init();
			Session::setSession("login", true);
			Session::setSession("id", $result->id);
			Session::setSession("name", $result->name);
			Session::setSession("username", $result->username);
			Session::setSession("loginmsg", "<div class='alert alert-success'><strong>Success!</strong> You are loggedIn</div>");
			header("Location: index.php");
		}else{
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Data not found</div>";
			return $msg;
		}
	}

	public function getLoginUser($email, $password){
		$sql="SELECT * FROM tbl_user WHERE email=:email AND password=:password LIMIT 1";
		$query= $this->db->pdo->prepare($sql);
		$query->bindValue(':email',$email);
		$query->bindValue(':password',$password);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_OBJ);
		return $result;
	}

	public function eamilCheck($email){
		$sql="SELECT email FROM tbl_user WHERE email=:email";
		$query= $this->db->pdo->prepare($sql);
		$query->bindValue(':email',$email);
		$query->execute();
		if($query->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function getUserData(){
		$sql="SELECT * FROM tbl_user ORDER BY id DESC";
		$query= $this->db->pdo->prepare($sql);
		$query->execute();
		$result=$query->fetchAll();
		return $result;
	}

	public function getUserById($id){
		$sql="SELECT * FROM tbl_user WHERE id=:id LIMIT 1";
		$query= $this->db->pdo->prepare($sql);
		$query->bindValue(':id',$id);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_OBJ);
		return $result;
	}
	public function updateUserData($id, $data){
		$name		=$data['name'];
		$username	=$data['username'];
		$email		=$data['email'];

		$chk_email	=$this->eamilCheck($email);

		if($name=="" or $username=="" or $email==""){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Fild must not be empty</div>";
			return $msg;
		}
		if(strlen($username)<3){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Username is too short</div>";
			return $msg;
		}elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Username must only contain alphanumerical, dashes and usderscores</div>";
			return $msg;
		}elseif(filter_var($email, FILTER_VALIDATE_EMAIL)===false){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Email Address is not valid</div>";
			return $msg;
		}

		// if ($chk_email==true) {
		// 	$msg="<div class='alert alert-danger'><strong>Error!</strong> Email Address already exist</div>";
		// 	return $msg;
		// }

		$sql="UPDATE tbl_user set
				name		=:name,
				username	=:username,
				email		=:email
				WHERE
				id=:id";
		$query= $this->db->pdo->prepare($sql);
		$query->bindValue(':name',$name);
		$query->bindValue(':username',$username);
		$query->bindValue(':email',$email);
		$query->bindValue(':id',$id);
		$result=$query->execute();
		if($result){
			$msg="<div class='alert alert-success'><strong>Success!</strong> User data Updated successfully</div>";
			return $msg;
		}else{
			$msg="<div class='alert alert-danger'><strong>Error!</strong> User data is not Updated</div>";
			return $msg;
		}
	}

	public function checkWithDbPassword($id, $password){
		$password=md5($password);
		$sql="SELECT password FROM tbl_user WHERE id=:id And password = :password";
		$query= $this->db->pdo->prepare($sql);
		$query->bindValue(':id',$id);
		$query->bindValue(':password',$password);
		$query->execute();
		if($query->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function updatePassword($id, $data){
		$old_password=$_POST['oldpassword'];
		$new_password=$_POST['newpassword'];

		$checkWithDbPassword=$this->checkWithDbPassword($id, $old_password);

		if($old_password=="" or $old_password==""){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Fild must not be empty</div>";
			return $msg;
		}elseif(strlen($new_password)<6){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Pasword can't be less then Six Character</div>";
			return $msg;
		}
		if($checkWithDbPassword==false){
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Old Password does not matched</div>";
			return $msg;
		}

		$new_password=md5($new_password);

		$sql="UPDATE tbl_user set
				password		=:password
				WHERE
				id=:id";
		$query= $this->db->pdo->prepare($sql);
		$query->bindValue(':password',$new_password);
		$query->bindValue(':id',$id);
		$result=$query->execute();
		if($result){
			$msg="<div class='alert alert-success'><strong>Success!</strong> Password Updated successfully</div>";
			return $msg;
		}else{
			$msg="<div class='alert alert-danger'><strong>Error!</strong> Password is not Updated</div>";
			return $msg;
		}
	}
}
?>