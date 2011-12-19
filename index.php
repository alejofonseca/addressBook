<?php
error_reporting(E_ALL);

// Path variables (CONSTANTS) 
define('ROOT',str_replace('\\','/',dirname(realpath(__FILE__))) . '/');
define('APPLICATION', ROOT . 'application/');

// Includes router
include ROOT . 'includes/router.php';

// Loads the index layout and initial view
Router::$rootPath = ROOT;
Router::$appPath = APPLICATION;
Router::loadLayout('index', 'html', 'index', 'html');
?>