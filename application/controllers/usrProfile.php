<?php
class UsrProfile extends Router
{
	public static $contactList;
	public static $interests;
	public static $msg = null;
	
	private static $addressBookData;
	private static $interestData;
	private static $session;
	
	public function __construct()
	{
		include parent::$rootPath . 'protected/dbConnection.php';
		include parent::$appPath . 'models/addressBook.php';
		include parent::$rootPath . 'includes/addressBookData.php';
		include parent::$appPath . 'models/users.php';
		include parent::$rootPath . 'includes/session.php';
		include parent::$appPath . 'models/interests.php';
		include parent::$rootPath . 'includes/interestsData.php';
		
		self::$addressBookData = new AddressBookData();
		self::$interestData = new InterestsData();
		self::$session = new Session();
	}
	
	/**
	 * Returns usrProfile (html) after any process
	 * @param array $arg
	 */
	public function loadUsrProfile($arg)
	{
		if( !empty($arg['viewVars']['usrProfileAction']) ){
			$action = $arg['viewVars']['usrProfileAction'];
			return $this->$action($arg);
		}
	}
	
	/**
	 * Returns usrProfile (html), no process executed (cancel)
	 * @param array $arg
	 */
	private function cancel($arg)
	{
		return $this->initialLoad($arg);
	}
	
	/**
	 * Returns usrProfile (html) after insert
	 * @param array $arg
	 */
	private function insert($arg)
	{
		$iArg = array('textNamesValues' => $arg['viewVars']['textNamesValues'],
					  'interests' => $arg['viewVars']['interests']);
		
		$inserted = self::$addressBookData->insertContact($iArg);

		if( $inserted ){
			self::$msg = "A new contact has been added to the database!";
			return $this->initialLoad($arg);
		}else{
			self::$msg = 'No changes were made to the contacts table';
			return $this->initialLoad($arg);
		}
	}
	
	/**
	 * Returns usrProfile (html) after delete
	 * @param array $arg
	 */
	private function delete($arg)
	{
		$deleted = self::$addressBookData->deleteContact($arg);
		if( $deleted ){
			self::$msg = "Contact with id '" . $arg['viewVars']['contactId'] . "'";
			self::$msg .= " was successfully deleted!";
			return $this->initialLoad($arg);
		}else{
			self::$msg = 'No changes were made to the contacts table';
			return $this->initialLoad($arg);
		}
	}
	
	/**
	 * Returns usrProfile (html) after edit
	 * @param array $arg
	 */
	private function edit($arg)
	{
		$uArg = array('contactId' => $arg['viewVars']['contactId'],
					  'textNamesValues' => $arg['viewVars']['textNamesValues'],
					  'interests' => $arg['viewVars']['interests']);
		
		$updated = self::$addressBookData->updateContact($uArg);

		if( $updated ){
			self::$msg = "Contact with id '" . $arg['viewVars']['contactId'] . "'";
			self::$msg .= " was successfully updated!";
			return $this->initialLoad($arg);
		}else{
			self::$msg = 'No changes were made to the contacts table';
			return $this->initialLoad($arg);
		}
	}
	
	/**
	 * Returns initial usrProfile (html)
	 * @param array $arg
	 */
	private function initialLoad($arg)
	{
		// Set self::$contactList and self::$interests
		$this->getContactList($arg);
		$this->getInterestsList();

		$viewString = parent::loadView($arg['viewName'] . '.' . $arg['viewFormat']);
		$viewString = str_replace('{msg}', self::$msg, $viewString);
		$viewString = str_replace('{contact_list}', self::$contactList, $viewString);
		$viewString = str_replace('{interests}', self::$interests, $viewString);
		return $viewString;
	}
	
	/**
	 * Returns usrProfile (html) after sort
	 * @param array $arg
	 */
	private function sort($arg)
	{
		if( $arg['viewVars']['interestId'] == 0 ){
			$arg['action'] = 'view_all';
		}else{
			$arg['action'] = 'sort';
		}
		$arg['sortId'] = $arg['viewVars']['interestId'];
		
		// Set self::$contactList
		$this->getContactList($arg);
		
		// Loads view content
		return self::$contactList;
	}
	
	/**
	 * Returns usrProfile (html) after login process
	 * @param unknown_type $arg
	 */
	private function login($arg)
	{
		// Login instance is called; if successful session starts.
		$login = self::$session->login($arg['viewVars']['usrname'],
								 hash('sha1',$arg['viewVars']['password']));
		
		if( $login ){

			// Session has been initiated. Load user profile.
			$arg['usrId'] = self::$session->getUsrId();
			return $this->initialLoad($arg);
			
		}else{

			// Loading index.html with usrname/passwd error msg.
			return 0;
			
		}
	}
	
	/**
	 * Puts contact list into self::$contactList.
	 * @param array $arg (usrId, contactId)
	 */
	private function getContactList($arg)
	{
		if( !empty($arg['action']) ){
			self::$addressBookData->action = $arg['action'];
		}
		
		$sortId = null;
		if( !empty($arg['sortId']) ){
			$sortId = $arg['sortId'];
		}
		
		session_start();
		$cLArg = array($_SESSION['usr_id'], $sortId);
		self::$addressBookData->interests = $this->getInterestsArray();
		self::$contactList = self::$addressBookData->createContactList($cLArg);

		return true;
	}
	
	/**
	 * Puts interest list in self::$interests
	 */
	private function getInterestsList()
	{
		self::$interests = self::$interestData->createInterestList();		
		return true;
	}
	
	/**
	 * Returns interest array
	 * @return array $interests
	 */
	public function getInterestsArray()
	{
		return self::$interestData->createInterestArray();
	}
	
	/**
	 * Returns AddressBookData object
	 */
	public static function getAddressBookData()
	{
		return self::$addressBookData;
	}
	
	/**
	 * Returns InterestData object
	 */
	public static function getInterestData()
	{
		return self::$interestData;
	}
	
	/**
	 * Returns Session object
	 */
	public static function getSession()
	{
		return self::$session;
	}
}
?>