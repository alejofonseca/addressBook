<?php
/**
 * This class is used to direct the app through the corresponding files.
 * @author Alejandro Fonseca.
 * @copyright 2011
 *
 */
class Router
{
	public static $appPath;
	public static $rootPath;
	private static $view;
	
	/**
	 * Loads the views.
	 * @param string $viewName
	 * @return string Html content or error message
	 */
	public static function loadView($viewName)
	{
		if( file_exists(self::$appPath . 'views/' . $viewName) ){
			return file_get_contents(self::$appPath . 'views/' . $viewName);
		}else{
			return 'Error: view file does not exists';
		}
	}
	
	/**
	 * Loads the layouts
	 * @param string $layoutName
	 * @return string HTML content for layout and a view inside it
	 */
	public static function loadLayout($layoutName,$layoutFormat,$viewName,$viewFormat)
	{
		$layoutFile = $layoutName . '.' . $layoutFormat;
		if( file_exists(self::$appPath . 'layouts/' . $layoutFile) ){
			echo file_get_contents(self::$appPath . 'layouts/' . $layoutFile);
		}else{
			echo 'Error loading file:' . self::$appPath . 'layouts/' . $layoutFile;
		}
	}
	
	/**
	 * Method that loads the corresponding controller.
	 * @param 
	 */
	public static function loadController($arg)
	{
		if( !empty($arg['parentClass']) ){
			include self::$appPath . 'controllers/' . $arg['parentClass'] . '.php';
		}
		
		$controllerPath = self::$appPath . 'controllers/' . $arg['viewName'] . '.php';
		if( file_exists($controllerPath) ){

			include $controllerPath;
			$controllerName = ucfirst($arg['viewName']);
			$controllerMethod = 'load' . ucfirst($arg['viewName']);
			$obj = new $controllerName();
			self::$view = $obj->$controllerMethod($arg);
			
		}else{
			
			self::$view = 'Error: Controller ' . $arg['viewName']
					    . '.php does not exist';
			
		}
	}
	
	/**
	 * Returns the private property $view
	 * @return string $view
	 */
	public static function getView()
	{
		return self::$view;
	}
}
?>