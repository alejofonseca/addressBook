<?php
class InterestsData extends Interests
{
	public function createInterestList()
	{
		$row = $this->getAll();
		
		$dataString = "<a href='#0' rel='interest'>View all</a><br />";
		foreach($row as $value){
			$dataString .= "<a href='#" . $value[0] . "' rel='interest'>";
				$dataString .= ucfirst($value[1]);
			$dataString .= "</a>";
			$dataString .= "<br />";
		}
		
		return $dataString;
	}
	
	public function createInterestArray()
	{
		return $this->getAll();
	}
}
?>