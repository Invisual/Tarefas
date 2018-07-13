<?php include('headers.php'); ?>
<link href="css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">

<title>INVISUAL - Adicionar Tarefa Diária</title>

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

$today = date('Y-m-d');
$tomorrow = new DateTime('tomorrow');


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
	
	$titulo = $_POST['titulo'];
	$descricao = $_POST['descricao'];
	$cliente = $_POST['cliente'];
	$user = $_POST['user'];


	try{		
		$log = new classes_UserManager($myControlPanel);
		$insert = $log->insertTarefaDiaria($titulo, $descricao, $cliente, $user);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}





?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-thumb-tack icons-header" title="Tarefas Diárias" aria-hidden="true"></i> &nbsp;Adicionar Tarefa Diária</h1>

<form name="tarefas" method="POST" enctype="multipart/form-data" action="">
<br>

<div class="row rowinsert">
	<div class="col-md-12">
		<input class="form-control" placeholder="Título da Tarefa Diária" type="text" name="titulo" id="titulo" required>
	</div>
</div>
<br>
<br>
<div class="row rowinsert">
	<div class="col-md-12">
		<textarea placeholder="Descrição da Tarefa Diária" class="form-control" name="descricao" style="height:100px !important;" rows="4"></textarea>
	</div>
</div>
<br>
<br>
<div class="row rowinsert">

	<div class="col-md-6">
		<select class="form-control" name="cliente" required>
		<option value="" disabled selected>Cliente</option>
		<?php
		$myDb = new classes_DbManager;
		$query = $myDb->_myDb->prepare("Select * from clientes order by nome");
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			{
			echo "<option value=".$row['id_cliente'].">".$row['nome']."</option>";
			}
		?>
		</select>
	</div>


	<div class="col-md-6">
		<select class="form-control" name="user" required>
		<option value="" disabled selected>Colaborador</option>
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
		<input type="submit" class="form-control btn btn-primary" value="Adicionar" onclick="check();" name="submit" id="submit">
	</div>
</div>

</form>



</div>


</body>


</html>