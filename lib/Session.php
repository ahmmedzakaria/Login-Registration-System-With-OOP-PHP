<?php


class Session {	
	public static function init(){
		if(version_compare(phpversion(), '5.4.0', '<')){
			if(session_id()==''){
				session_start();
			}
		}else{
			if(session_status()==PHP_SESSION_NONE){
				session_start();
			}
		}
	}
	public static function setSession($key, $val){
		$_SESSION[$key] = $val;
	}
	public static function getSession($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return false;
		}
	}

	public static function destroySession(){
		session_decode();
		session_unset();
		header("Location: login.php");
	}

	public static function checkSession(){
		if(self::getSession("login")==false){
			self::destroySession();
			header("Location: login.php");
		}
	}

	public static function checkLogin(){
		if(self::getSession("login")==true){
			header("Location: index.php");
		}
	}
}
?>