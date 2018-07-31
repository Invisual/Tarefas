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


$db = classes_DbManager::ob();

$getTarefa = $db -> listTarefa($idtarefa);

while($dados= $getTarefa->fetch(PDO::FETCH_ASSOC)){
    $titulo = $dados['titulo'].' - CÓPIA';
    $desc = $dados['descricao'];
	$datafim = $dados['data_fim'];
    $cliente = $dados['cliente_id'];
	$diaria = $dados['diaria'];
	$avenca = $dados['avenca'];
}


$getIntervenientes = $db -> usersTarefa($idtarefa);
$intervenientes = [];

while($users= $getIntervenientes->fetch(PDO::FETCH_ASSOC)){
    $iduser = $users['user_interv_id'];
	array_push($intervenientes, $iduser);
}

try{		
	$log = new classes_UserManager($myControlPanel);
	$insert = $log->insertTarefa($titulo, $desc, $cliente, $datafim, $intervenientes, $diaria, $avenca);
	
}
catch (invalidArgumentException $e){

	$e->getMessage();
}



header("Location:list_tarefas.php");


?>