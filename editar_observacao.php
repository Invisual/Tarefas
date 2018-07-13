<?php include('headers.php'); ?>
<link href="css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
<title>INVISUAL - Editar Observação</title>


<style>
.btn-primary{
	background-color:#2f323a !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#ffffff !important;
	border:none !important;
}

.btn-primary:hover{
	background-color:#5093e1 !important;
	border:none !important;
}

input[type="text"]{
	height:40px;
	width:75%;
}

</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']!=1){
	header('location:index.php');
}


$idobs = $_GET['idobs'];
$idtarefa = $_GET['idtarefa'];

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
	
	$texto = $_POST['texto_obs'];

	try{		
		$log = new classes_UserManager($myControlPanel);
		$update = $log->updateObservacao($idobs, $texto, $idtarefa);
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}




$obj = new classes_DbManager ();
$dado = $obj-> listObservacao($idobs);

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
    $texto_observacao = $dados['texto'];
}





?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header">Editar Observação</h3>


<form name="observacoes" method="POST" enctype="multipart/form-data" action="">
<br>


<div class="row rowinsert">
	<div class="col-md-12">
		<input type="text" name="texto_obs" value="<?php echo $texto_observacao?>">
	</div>
</div>

<br>
<br>
<div class="row rowinsert" style="margin-top:5vh;">
	<div class="col-md-12">
		<input type="submit" class="form-control btn btn-primary" value="Editar" name="submit" id="submit">
	</div>
</div>

</form>



</div>

</body>

</html>