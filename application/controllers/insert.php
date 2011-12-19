<?php
class Insert extends UsrProfile
{
	public static $insertForm;
	
	private static $addressBookData;
	
	public function __construct()
	{
		parent::__construct();
		self::$addressBookData = parent::getAddressBookData();
	}
	
	/**
	 * Gets insert form.
	 * @param array $arg
	 * @return string Insert form view
	 */
	public function loadInsert($arg)
	{
		self::$addressBookData->interests = parent::getInterestsArray();
		self::$insertForm = self::$addressBookData->createInsertForm();

		$viewString = parent::loadView($arg['viewName'] . '.' . $arg['viewFormat']);
		$viewString = str_replace('{insert_form}', self::$insertForm, $viewString);
		
		return $viewString;
	}
}
?>