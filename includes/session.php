<?php
class Session extends Users
{
	private $usrId = null;
	
	public function login($usrname,$password)
	{
		$this->username = $usrname;
		$this->password = $password;
		
		$this->usrId = $this->checkPasswords();
		
		// Close db connection
		$this->closeDb();
		
		if( $this->usrId ){
			session_start();
			$_SESSION['usr_id'] = $this->usrId;
			$_SESSION['usr_name'] = $this->username;
			return true;
		}else{
			return false;
		}
	}
	
	public function logout()
	{
		unset($_SESSION);
		session_destroy();
	}
	
	public function getUsrId()
	{
		return $this->usrId;
	}
}
?>