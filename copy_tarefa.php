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
	$tipo = $dados['tipo_tarefa'];
}


$getIntervenientes = $db -> usersTarefa($idtarefa);
$intervenientes = [];

while($users= $getIntervenientes->fetch(PDO::FETCH_ASSOC)){
    $iduser = $users['user_interv_id'];
	array_push($intervenientes, $iduser);
}







try{		
	$log = new classes_UserManager($myControlPanel);
	$insert = $log->insertTarefa($titulo, $desc, $cliente, $datafim, $intervenientes, $diaria, $avenca, $tipo);

	$getId = $db -> getLastId();
	while($dadosid= $getId->fetch(PDO::FETCH_ASSOC)){
		$idval = $dadosid['id_tarefa'];
	}

	$getCustos = $db -> listarRegistosCustosTarefa($idtarefa);
	while($dadosCustos= $getCustos->fetch(PDO::FETCH_ASSOC)){
		$servico = $dadosCustos['servico'];
		$custofornecedor = $dadosCustos['custo_fornecedor'];
		$custovenda = $dadosCustos['custo_venda'];
		$fornecedor = '.';

		$insertCusto = $log->insertCustosTarefa($idval, $servico, $custofornecedor, $custovenda, $fornecedor, 2);
	}
	
}
catch (invalidArgumentException $e){

	$e->getMessage();
}



header("Location:listar_tarefa.php?id=".$idval);


?>