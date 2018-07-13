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

$val = $_GET['val'];



$obj = classes_DbManager::ob();

$avencartarefa = $obj -> avencarTarefa($idtarefa, $val);


if(isset($_GET['link'])){
	header("Location:$link&conc=$conc");
}
else{
header("Location:listar_tarefa.php?id=$idtarefa");
}

?>