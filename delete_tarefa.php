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
$idcliente = $_GET["cliente"];

$delete = classes_DbManager::ob();

$deletemsgs = $delete -> deleteMessagesByTarefa($idtarefa);
$deleteintervs = $delete -> deleteIntervenientesByTarefa($idtarefa);
$deletenotif = $delete-> deleteNotificacaoByTarefa($idtarefa);
$deletenotifmsg = $delete-> deleteNotificacaoMensagemByTarefa($idtarefa);
$deleteordem = $delete-> deleteOrdem($idtarefa);
$deletehoras = $delete-> deleteHoras($idtarefa);
$deleteobservacoes = $delete-> deleteObservacoes($idtarefa);
$deletetarefa = $delete-> deleteTarefa($idtarefa);

if(!empty($idcliente)){
	header("Location:list_tarefas.php?cliente=$idcliente");
}
else{
	header("Location:list_tarefas.php");
}

?>