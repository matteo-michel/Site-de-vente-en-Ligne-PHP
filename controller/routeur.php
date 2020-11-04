<?php
require_once File::build_path(array('controller','controllerUtilisateur.php'));

if (!isset($_GET['controller']))
	$controller = 'utilisateur';

$controller_class = 'Controller'. ucfirst($controller);
$action = 'readAll';
if(!isset($_GET['action']) && !isset($_POST['action'])){
		$action = 'readAll'; 
	} else if(isset($_GET['action'])){
		$action = $_GET['action'];
	} else {
		$action = $_POST['action'];
	}
$controller_class::$action();

?> 
