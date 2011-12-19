<?php
// Path variables
$rootPath = str_replace('\\','/',dirname(realpath(__FILE__)));
define('ROOT',str_replace('application/controllers','',$rootPath));
define('APPLICATION', ROOT . 'application/');

// Gets json data: array($viewName, ROOT, APPLICATION)
$postData = json_decode(stripslashes($_POST['data']),true);

// Includes the router
include ROOT . 'includes/router.php';
Router::$appPath = APPLICATION;
Router::$rootPath = ROOT;

// Includes view controller
//Router::loadController($postData['viewName'],$postData['viewFormat'],$postData['viewVars']);
Router::loadController($postData);

echo json_encode(array('viewContent' => Router::getView()));
?>