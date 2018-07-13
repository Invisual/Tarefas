<?php


    $iduser = $_SESSION['id'];

	$count = classes_DbManager::ob();

	$countNotificacoes= $count->contarNotificacoes($iduser);

	$getNotificacoes= $count->getNotificacoes($iduser); 
	
	$countNotificacoesMensagens= $count->contarNotificacoesMensagens($iduser);

	$countNotificacoesHoras= $count->contarNotificacoesHoras($iduser);

	$getNotificacoesMensagens= $count->getNotificacoesMensagens($iduser); 



?>