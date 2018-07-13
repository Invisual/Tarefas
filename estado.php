<?php
;
require_once ('utils/Autoloader.php');
session_start();

if (empty($myControlPanel)) {

	try {

	$myControlPanel = new classes_ControlPanel();

	$myControlPanel->setMyDb(classes_DbManager::ob());

	$myDbManager = $myControlPanel->getMyDb();

	}


	catch (Exception $e) {

		echo $e->getMessage();
		die();
	}
}


if($_SESSION['logged_in']!=1){
	header('location:index.php');
}


$idtarefa=$_GET["id"];
$estado = $_GET['state'];

if($estado==0){
	$val = 1;
}
else if($estado==1){
	$val = 2;
}
else if($estado==2){
	$val = 3;
}
else if($estado==3){
	$val = 4;
}
else if($estado==4){
	$val = 5;
}
else if($estado==5){
	$val = 0;
}

$update = new classes_UserManager($myControlPanel);
$updatedestaque = $update-> updateEstado($idtarefa, $val);

header("Location:list_tarefas.php");

?>