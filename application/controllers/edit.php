<?php
class Edit extends UsrProfile
{
	public static $editForm;
	
	private static $addressBookData;
	
	public function __construct()
	{
		parent::__construct();
		self::$addressBookData = parent::getAddressBookData();
	}
	
	/**
	 * Returns edit form.
	 * @param string $arg
	 * @return string Edit Form
	 */
	public function loadEdit($arg)
	{
		self::$addressBookData->interests = parent::getInterestsArray();
		self::$editForm = self::$addressBookData->createEditForm($arg['viewVars']['contactId']);

		$viewString = parent::loadView($arg['viewName'] . '.' . $arg['viewFormat']);
		$viewString = str_replace('{edit_form}', self::$editForm, $viewString);
		
		return $viewString;
	}
}
?>