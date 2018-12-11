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


$idtarefa=$_POST["idtarefa"];
$observacoes=$_POST["observacoes"];
$valfaturada=$_POST["valfaturada"];
$titulotarefa=$_POST["titulotarefa"];
$user=$_POST['user'];
$tipo=$_POST['tipo'];


$processar = classes_DbManager::ob();

$processartarefa = $processar -> processarTarefa($idtarefa, $observacoes, $valfaturada, $titulotarefa);
$registoProcessarTarefa = $processar -> inserirRegistoProcessarTarefa($idtarefa, $user);

if($tipo == 2){
	header("Location:listagem_admin.php");
}
else{
	header("Location:listar_tarefa.php?id=$idtarefa");
}



?>