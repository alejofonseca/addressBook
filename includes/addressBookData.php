<?php
class AddressBookData extends AddressBook
{
	public $interests;
	public $action = 'view_all';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Method used to load the contactList
	 * @param array $arg (usrId)
	 */
	public function createContactList($arg)
	{
		$this->usrId = $arg[0];
		
		$row = $this->getAllById();
		
		if( $this->action == 'sort' ){
			
			$data = array();
			
			if( $arg[1] !== '0' ){
				foreach($row as $value){
					$interests = explode(',',$value[7]);
					if( in_array($arg[1], $interests) ){
						$data[] = $value;
					}
				}
				
				unset($row);
				$row = $data;
				
			}else{
				
				$row = $data;
			
			}
			
		}
		
		$dataString = "<table border='0' id='contactList' cellpadding='4' cellspacing='4'>";
		$dataString .= "<thead>";
		$dataString .= "<tr>";
		$dataString .= "<th>Contact Id</th>";
		$dataString .= "<th>First Name</th>";
		$dataString .= "<th>Last Name</th>";
		$dataString .= "<th>City</th>";
		$dataString .= "<th>State</th>";
		$dataString .= "<th>Zip</th>";
		$dataString .= "<th>Interests</th>";
		$dataString .= "</tr>";
		$dataString .= "</thead>";
		
		$dataString .= "<tbody>";
		foreach($row as $value){
			$dataString .= "<tr>";
			foreach($value as $k=>$element){
				
				if( $k != 1 && $k != 7 ){
					
					// Do not show contact_id or usr_id columns
					$dataString .= "<td>";
					$dataString .= $element;
					$dataString .= "</td>";
					
				}
				
				if( $k == 7 ){
					
					unset($interests,$intField,$intArray);
					$interests = explode(',',$element);
					foreach($this->interests as $intArray){
						if( in_array($intArray[0], $interests) ){
							$intField[] = $intArray[1];
						}
					}
					$dataString .= "<td>";
					$dataString .= implode(', ', $intField);
					$dataString .= "</td>";
				
				}
			
			}
			
			$dataString .= "<td>";
			$dataString .= "<input type='button' class='button' id='e" . $value[0] . "' ";
				$dataString .= "value='edit' />";
			$dataString .= "<input type='button' class='button' id='d" . $value[0] . "' ";
				$dataString .= "value='delete' />";
			$dataString .= "<td>";
			
			$dataString .= "</tr>";
		}
		
		$dataString .= "</tbody>";
		$dataString .= "</table>";
		
		$this->closeDb();
		
		return $dataString;
	}
	
	public function createEditForm($contactId)
	{
		$this->contactId = $contactId;
		$row = $this->getAllByContactId();
		
		$dataString .= "<form name='editForm' id='editForm' action='' method='post'>";
			$dataString .= "<table>";
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "First Name: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='name' id='name' ";
				$dataString .= "value='" . $row[2] . "'/>";
			$dataString .= "<td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "Last Name: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='last_name' id='last_name' ";
				$dataString .= "value='" . $row[3] . "'/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "City: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='city' id='city' ";
				$dataString .= "value='" . $row[4] . "'/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "State: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='state' id='state' ";
				$dataString .= "value='" . $row[5] . "'/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "Zip: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='zip' id='zip' ";
				$dataString .= "value='" . $row[6] . "'/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "Interests:";
			$dataString .= "</td>";
			$dataString .= "<td>";
			
			$interests = explode(',',$row[7]);
			foreach($this->interests as $value){
				if( in_array($value[0], $interests) ){
					// Check the box
					$dataString .= "<input type='checkbox' name='interests' id='interests' ";
						$dataString .= "value='" . $value[0] . "' checked='checked'/>";
				}else{
					// Leave box empty
					$dataString .= "<input type='checkbox' name='interests' id='interests' ";
						$dataString .= "value='" . $value[0] . "'/>";
				}
				$dataString .= ucfirst($value[1]) . "<br />";
			}
			
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td colspan='2' align='center'>";
				$dataString .= "<input type='hidden' id='contactId' value='$contactId' />";
				
				$dataString .= "<input type='submit' id='save' value='Save' />";
				$dataString .= "<input type='button' id='cancel' value='Cancel' />";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "</table><br />";
		$dataString .= "</form>";
		
		$this->closeDb();
		
		return $dataString;
	}
	
	public function createInsertForm()
	{
		$dataString .= "<form name='insertForm' id='insertForm' action='' method='post'>";
			$dataString .= "<table>";
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "First Name: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='name' id='name' ";
				$dataString .= "value=''/>";
			$dataString .= "<td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "Last Name: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='last_name' id='last_name' ";
				$dataString .= "value=''/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "City: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='city' id='city' ";
				$dataString .= "value=''/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "State: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='state' id='state' ";
				$dataString .= "value=''/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "Zip: * ";
			$dataString .= "</td>";
			$dataString .= "<td>";
				$dataString .= "<input type='text' name='zip' id='zip' ";
				$dataString .= "value=''/>";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td>";
				$dataString .= "Interests:";
			$dataString .= "</td>";
			$dataString .= "<td>";
			
			foreach($this->interests as $value){
				// Leave box empty
				$dataString .= "<input type='checkbox' name='interests' id='interests' ";
					$dataString .= "value='" . $value[0] . "'/>";
				$dataString .= ucfirst($value[1]) . "<br />";
			}
			
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "<tr>";
			$dataString .= "<td colspan='2' align='center'>";
				$dataString .= "<input type='submit' id='save' value='Insert' />";
				$dataString .= "<input type='button' id='cancel' value='Cancel' />";
			$dataString .= "</td>";
			$dataString .= "</tr>";
			
			$dataString .= "</table><br />";
		$dataString .= "</form>";
		
		return $dataString;
	}
	
	/**
	 * Method used to insert a new contact through the
	 * parent::updateContactId()
	 * @param array $arg (array textNamesValues, array interests)
	 * @return true if mysql query is successful, false if is not.
	 */
	public function insertContact($arg)
	{
		session_start();
		
		$prepare = "INSERT INTO contacts (";
		$prepare .= "usr_id,";
		foreach($arg['textNamesValues'] as $value){
			$text = explode(',',$value);
			$prepare .= $text[0] . ",";
		}
		$prepare .= "interests";
		$prepare .= ") ";
		$prepare .= "VALUES ";
		$prepare .= "(";
		$prepare .= "'" . $_SESSION['usr_id'] . "',";
		unset($text);
		foreach($arg['textNamesValues'] as $value){
			$text = explode(',',$value);
			$prepare .= "'" . $text[1] . "',";
		}
		$prepare .= "'" . implode(',',$arg['interests']) . "'";
		$prepare .= ");";
		$confirm = $this->updateTable($prepare);
		
		return $confirm;
	}
	
	/**
	 * Method used to update a contact through the
	 * parent::updateContactId()
	 * @param array $arg (int contactId, array textNamesValues, array interests)
	 * @return true if mysql query is successful, false if is not.
	 */
	public function updateContact($arg)
	{
		$prepare = "UPDATE contacts SET ";
		foreach($arg['textNamesValues'] as $value){
			$text = explode(',',$value);
			$prepare .= $text[0] . "='$text[1]',";
		}
		
		$prepare .= "interests='" . implode(',',$arg['interests']) . "' ";
		$prepare .= "WHERE contact_id='" . $arg['contactId'] . "';";
		$confirm = $this->updateTable($prepare);

		return $confirm;
	}
	
	/**
	 * Method used to delete a contact in parent::deleteContactId()
	 * @param array $arg (viewName, viewFormat, viewVars)
	 * @return true if mysql query is successful, false if is not.
	 */
	public function deleteContact($arg)
	{
		$prepare = "DELETE FROM contacts WHERE ";
		$prepare .= "contact_id = '" . $arg['viewVars']['contactId'] . "';";
		$confirm = $this->updateTable($prepare);

		return $confirm; 
	}
}
?>