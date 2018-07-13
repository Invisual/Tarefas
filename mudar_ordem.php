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


if(!empty($_POST)){
	
	$idtarefa = $_POST['idtarefa'];
	$valordem= $_POST['ordem'];
	$userid = $_POST['iduser'];
	try{		
		$log = new classes_UserManager($myControlPanel);
		$update = $log->updateOrdemTarefa($idtarefa, $userid, $valordem);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}

header("location:javascript://history.go(-1)");

?>