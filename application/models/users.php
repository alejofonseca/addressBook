<?php
class Users extends DbConnection
{
	protected $username;
	protected $password;
	
	private $usrData;
	private $db;
	
	public function __construct()
	{
		$this->db = parent::__construct('localhost','root','1607','abapp');
	}
	
	private function getUsrPass()
	{
		$sql = "SELECT usr_id,usr_pass FROM users WHERE "
			 . "usr_name = '" . $this->username . "';";
		$result = $this->db->query($sql);
		return $result->fetch_row();
	}
	
	protected function checkPasswords()
	{
		$this->usrData = self::getUsrPass();
		
		if( $this->usrData[1] === $this->password ){
			return $this->usrData[0];
		}else{
			return null;
		}
	}
	
	protected function closeDb()
	{
		$this->db->close();
	}
}
?>