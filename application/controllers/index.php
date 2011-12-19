<?php
class Index extends Router
{
	public function __construct()
	{
		
	}
	
	/**
	 * Gets index view. If logout exists -> end session
	 * @param $arg
	 */
	public function loadIndex($arg)
	{
		if( $arg['viewVars']['logout'] === 1 ){
			$this->logout();
		}
		
		return parent::loadView($arg['viewName'] . '.' . $arg['viewFormat']);
	}
	
	/**
	 * Session destroy
	 */
	private function logout()
	{
		session_start();
		unset($_SESSION);
		session_destroy();
	}
}
?>