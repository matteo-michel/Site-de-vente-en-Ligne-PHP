<?php
require_once File::build_path(array('controller','controllerUtilisateur.php'));
require_once File::build_path(array('controller','controllerBook.php'));

if (!isset($_GET['controller']))
	$controller = 'book';

$controller_class = 'controller'. ucfirst($controller);
$action = 'readAll';
if(!isset($_GET['action']) && !isset($_POST['action']))
{
	$action = 'readAll';
} else if(isset($_GET['action']))
{
	$action = $_GET['action'];
} else {
	$action = $_POST['action'];
}


$controller_class::$action();

?> 
