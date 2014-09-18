<?php
class UserModel{
	private $username;
	private $password;

	function __construct($username = "", $password = ""){
		$this->username = $username;
		$this->password = $password;
	}
	// Checks if the user exists
	function userExists($username, $password){
		if($username == 'Admin' && $password == 'Password'){
			return true;
		}
		return false;
	}
	function checkSession(){
		if(isset($_SESSION["loggedin"])){
			if($_SESSION["remote_addr"] != $_SERVER["REMOTE_ADDR"]||$_SESSION["useragent"]!=$_SERVER["HTTP_USER_AGENT"])
			{
				unset($_SESSION["loggedin"]);
				header("location: ".$_SERVER["PHP_SELF"]);
			}
		}
	}
	function loginUser($username){
		$_SESSION["loggedin"] = true;
		$_SESSION["remote_addr"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION["useragent"] = $_SERVER["HTTP_USER_AGENT"];
		return;
	}
	function logoutUser(){
		unset($_SESSION["loggedin"]);
		unset($_SESSION["remote_addr"]);
		unset($_SESSION["useragent"]);
		return;
	}
	function isUserLoggedIn(){
		if(isset($_SESSION["loggedin"])){
			return true;
		}
		return false;
	}
	function checkToken($username, $cookie){
		list($token, $expirytime) = $this->getTokenFromFile($username);
		if($token === $cookie && $expirytime >= time()){
			return true;
		}
		return false;
	}
	function getTokenFromFile($username){
		$fp = fopen($username, 'r');
		$content = fread($fp,filesize($username));
		fclose($fp);
		list($token, $expirytime) = explode("\n",$content);
		return array($token, $expirytime);
	}
	function saveToken($username, $token, $expirytime){
		$fp = fopen($username, 'w');
		fwrite($fp, $token . "\n" . $expirytime);
		fclose($fp);
	}
	function getNewToken(){
		return "hejdär";
	}
}