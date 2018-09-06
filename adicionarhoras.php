<?php include('headers.php'); ?>
<link href="css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
<title>INVISUAL - Editar Horas</title>


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

input[type="text"]{
    height:35px;
}
</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

$today = date('Y-m-d');
$tomorrow = new DateTime('tomorrow');

if($_SESSION['logged_in']!=1){
	header('location:index.php');
}


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
	
	$hora_inicio = $_POST['hora_inicio'];
	$hora_fim = $_POST['hora_fim'];
	$dia = $_POST['dia'];
	$user = $_POST['user'];

	
	try{		
		$log = new classes_UserManager($myControlPanel);
		$update = $log->adicionarHora($hora_inicio, $hora_fim, $dia, $user, $idtarefa);
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}




?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header">Adicionar Registo de Horas</h3>

<form name="tarefas" method="POST" enctype="multipart/form-data" action="">
<br>


<div class="row rowinsert">
	<div class="col-md-6">
	    <label>Hora de Início:</label>
		<input type="text" name="hora_inicio" placeholder="hh:mm">
	</div>
	<div class="col-md-6">
	    <label>Hora de Fim:</label>
		<input type="text" name="hora_fim" placeholder="hh:mm">
	</div>
</div>
<div class="row rowinsert">
	<div class="col-md-6">
	    <label>Dia:</label>
		<input type="text" name="dia" placeholder="dd/mm">
	</div>
	<div class="col-md-6">
	    <label>Utilizador:</label>
		<select name="user">
			<option value="-" selected>Colaboradores</option>
				<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users order by nome_user");
				$query->execute();
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{
					echo "<option value=".$row['id_user'].">".$row['nome_user']."</option>";
					}
				?>
		</select>
	</div>
</div>

<br>
<br>
<div class="row rowinsert" style="margin-top:5vh;">
	<div class="col-md-12">
		<input type="submit" class="form-control btn btn-primary" value="Adicionar" name="submit" id="submit">
	</div>
</div>

</form>



</div>

</body>

</html>