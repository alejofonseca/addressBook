<?php
class AddressBook extends DbConnection
{
	protected $usrId;
	protected $contactId;
	protected $interestId;
	
	private $db;
	
	public function __construct()
	{
		$this->db = parent::__construct('localhost','usr','password','database');
	}
	
	protected function getAllById()
	{
		$sql = "SELECT * FROM contacts WHERE "
			 . "usr_id = '" . $this->usrId . "' ORDER BY name ASC;";
		$result = $this->db->query($sql);
		
		$arg = array($this->db->field_count,$result);
		$matrix = $this->fetch_row_array($arg);

		$result->close();
		return $matrix;
	}
	
	protected function getAllByContactId()
	{
		$sql = "SELECT * FROM contacts WHERE "
			 . "contact_id = '" . $this->contactId . "';";
		$result = $this->db->query($sql);
		$row = $result->fetch_row();
		
		$result->close();
		return $row;
	}
	
	protected function updateTable($sql)
	{
		$this->db->query($sql);
		
		if( $this->db->affected_rows > 0 ){
			return true;
		}else{
			return false;
		}
	}
	
	protected function closeDb()
	{
		$this->db->close();
	}
}
?>