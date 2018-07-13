<?php include('headers.php'); ?>

<title>INVISUAL - Adicionar Tarefa</title>

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

$today = date('Y-m-d');
$tomorrow = new DateTime('tomorrow');

if($_SESSION['logged_in']!=1){
	header('location:index.php');
}


if($_SESSION['admin']!=1 && !isset($_GET['id'])){
	header('location:index.php');
}

$idtask = $_GET['id'];

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
	
	$prioridade = $_POST['prioridade'];
	
	try{		
		$log = new classes_UserManager($myControlPanel);
		$update = $log->updateTaskPrioridade($prioridade, $idtask);
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}




$obj = new classes_DbManager ();
$dado = $obj-> listSingleTask($idtask);

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
    $titulo = $dados['titulo'];
    $desc = $dados['descricao_task'];
    $cliente = $dados['nome'];
    $nomeuser = $dados['nome_user'];
	$prioridade = $dados['id_prioridade'];
	
}





?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header">Editar Prioridade da <strong>Tarefa</strong></h1>

<div class="row rowtarefa">
		<div class="col-md-12">

			<h3>Projeto - <strong><?php echo $titulo ?></strong></h3>
			<h4 style="font-size:1.3em;">Cliente - <strong><?php echo $cliente; ?></strong></h4>
			<h4 style="font-size:1.3em;">Colaborador - <strong><?php echo $nomeuser; ?></strong></h4>
			<p style="font-size:1.3em;"><strong>Task - </strong><?php echo $desc ?></p>
			
			<form method="POST" action="" style="padding-bottom:50px; padding-left:35px;">

				<div class="row" style="width:70%;">

					<div class="col-md-9">
						<select class="form-control" name="prioridade" style="height:34px !important; background-color:#edeff5;" required>
								<option value="" disabled selected><span style='color:red !important;'>Prioridade</span></option>
								<?php
								$myDb = new classes_DbManager;
								$query = $myDb->_myDb->prepare("Select * from prioridade");	
								$query->execute();
								while($row = $query->fetch(PDO::FETCH_ASSOC))
									{
									echo "<option ". ($prioridade == $row['id_prioridade'] ? 'selected = "selected"':'') ." value=".$row['id_prioridade'].">".$row['nome_prioridade']."</option>";
									}
								?>
						</select>
					</div>

					<div class="col-md-3">
						<input type="submit" name="submit" value="Alterar" id="btnprioridade" class="btn btn-primary">
					</div>

				</div>

			</form>

		</div>
</div>




</div>

</body>

</html>