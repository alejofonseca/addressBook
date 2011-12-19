<?php
class Interests extends DbConnection
{
	private $db;
	
	public function __construct()
	{
		$this->db = parent::__construct('localhost','root','1607','abapp');
	} 
	
	protected function getAll()
	{
		$sql = "SELECT * FROM interests";
		$result = $this->db->query($sql);
		
		$arg = array($this->db->field_count,$result);
		$matrix = $this->fetch_row_array($arg);
		
		$result->close();
		return $matrix;
	}
	
	protected function closeDb()
	{
		$this->db->close();
	}
}
?>