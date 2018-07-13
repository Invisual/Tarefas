<?php include('headers.php'); ?>

<title>INVISUAL - Adicionar Cliente</title>

<style>
.btn-primary{
	background-color:#2f323a !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#fff !important;
	border:none !important;
}

.btn-primary:hover{
	background-color:#5093e1 !important;
	border:none !important;
}

</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']!=1){
	header('location:index.php');
}

if($_SESSION['admin'] != 1){
 	header('location:index.php');
}

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






if(!empty($_POST)){
	
	$nome = $_POST['nome'];
	$nome = strtoupper(strtr($nome ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	
	try{		
		$log = new classes_UserManager($myControlPanel);
		$insert = $log->insertCliente($nome);
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}





?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-users icons-header" title="Clientes" aria-hidden="true"></i> &nbsp;Adicionar Cliente</h1>

<form name="clientes" method="POST" enctype="multipart/form-data" action="">
<br>

<div class="row rowinsert">
	<div class="col-md-12">
		<input required class="form-control" placeholder="Nome do Cliente" type="text" name="nome" id="nome" >
	</div>
</div>
<br>
<br>
<div class="row rowinsert" style="margin-top:5vh;">
	<div class="col-md-12">
		<input type="submit" class="form-control btn btn-primary" name="submit" id="submit">
	</div>
</div>

</form>



</div>

</body>

</html>