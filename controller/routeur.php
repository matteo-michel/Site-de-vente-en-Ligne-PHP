<?php
require_once File::build_path(array('controller','controllerUtilisateur.php'));
require_once File::build_path(array('controller','controllerBook.php'));


if (!isset($_GET['controller']))
	$controller = 'book';
else
	$controller = $_GET['controller'];

if(!isset($_GET['action']) && !isset($_POST['action']))
{
	$action = 'readAll';
} else if(isset($_GET['action']))
{
	$action = $_GET['action'];
} else {
	$action = $_POST['action'];
	if (in_array($action, get_class_methods('controllerUtilisateur'))) $controller = 'utilisateur';
}

$controller_class = 'controller'. ucfirst($controller);
$controller_class::$action();

?> 
