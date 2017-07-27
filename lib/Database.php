<?php


/**
* 
*/
class DAtabase {
	private $hostdb="localhost";	
	private $userdb="root";
	private $passdb="";
	private $namedb="db_register_login_system";
	public $pdo;
	function __construct()
	{
		if(!isset($pdo)){
			try {
				$pdo= new PDO("mysql: host=".$this->hostdb.";dbname=".$this->namedb, $this->userdb, $this->passdb);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo->exec("SET CHARACTER SET utf8");
				$this->pdo=$pdo;
				// if(!($this->pdo==null)){
				// 	echo "connected";
				// }
			} catch (PDOException $e) {
				die("Failed to connect with database".$e->getMassage());
			}

		}
	}
}