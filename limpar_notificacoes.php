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


$iduser=$_GET["id"];
$link = $_GET["link"];

$limpar = classes_DbManager::ob();

$limparnot = $limpar -> limparNotificacoes($iduser);



header("Location:".$link);

?>