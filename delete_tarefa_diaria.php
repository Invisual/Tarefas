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


$delete = classes_DbManager::ob();

$deletetarefa = $delete-> deleteTarefaDiaria($idtarefa);


header("Location:list_tarefas_diarias.php");


?>