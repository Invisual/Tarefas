<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>

<style>
    
    #alternar-estado{
        padding-left:3vw;
    }

	.isavenca{
		color: #5093e1;
    font-weight: 600;
    font-size: 22px;
    margin-top: 10px;
	}
    
</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

$idcliente = $_GET['cliente'];

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if($_SESSION['logged_in']!=1){
	header('location:index.php');
}

if(!empty($idcliente)){ $x = 1; } else { $x = 0; }


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
	
	$idtarefa = $_POST['tarefaid'];
	$valestado= $_POST['estado'];

	try{		
		$log = new classes_UserManager($myControlPanel);
		$update = $log->updateEstadoTarefa($idtarefa, $valestado);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}


?>


<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<?php if($x == 1){ 
$myDb = new classes_DbManager;
$queryCliente = $myDb->_myDb->prepare("Select * from clientes where id_cliente='$idcliente'");
$queryCliente->execute();
while($row = $queryCliente->fetch(PDO::FETCH_ASSOC)){
?>
<h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp;Todas as <strong>Tarefas</strong> de <strong><?php echo $row['nome']; ?></strong> </h3>
<?php } }
else {?>
<h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp; Todos as <strong>Tarefas</strong></h3>



<?php } ?>

<?php if(isset($_GET['conc'])){
	if($_GET['conc'] == 1){
		$mostrarConc = true;
	}
} ?>

<input type="checkbox" id="alternar-estado" <?php if($mostrarConc){ echo 'checked'; }?>>
<label for="alternar-estado"> &nbsp; Mostrar Tarefas Já Concluídas</label>


<?php


$obj = new classes_DbManager ();

if($x == 1){
	$dado = $obj-> listarTarefas($idcliente);
}
else{
	$dado = $obj-> listarTarefas(0);
}

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
$corpo = $dados['descricao'];
$corpo = substr($corpo,0,75);
$urg = $dados['urgente'];
$estado = $dados['estado'];
$process = $dados['processada'];
$avenca = $dados['avenca'];
$newDateIni = date("d-m-Y", strtotime($dados['data_ini']));
$newDateFim = date("d-m-Y", strtotime($dados['data_fim']));

$myDb = new classes_DbManager;
$interv = $obj->_myDb->prepare("Select * from intervenientes_tarefa INNER JOIN users on intervenientes_tarefa.user_interv_id=users.id_user where tarefa_interv_id = '$dados[id_tarefa]'");
$interv->execute();

if($estado == 0){
	$state = "Por Iniciar";
}
else if($estado == 1){
	$state = "Em Curso";
}
else if($estado == 2){
	$state = "Concluída";
}
else if($estado == 3){
	$state = "Pausa";
}
else if($estado == 4){
	$state = "Aguarda<br>Aprovação<br>Interna";
}
else if($estado == 5){
	$state = "Aguarda<br>Aprovação<br>Externa";
}
 ?>


	<div class="row row-list estado-<?php echo $estado ?>" style="margin: 5vh auto;<?php if($estado==2){echo "border-bottom:4px solid black !important;";}?><?php if($process==1){echo "border-bottom:4px solid #5093e1 !important;";}?><?php if($urg==1){echo "border-bottom:4px solid red;";}?>">

		<a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']; ?>&linktodas=<?php echo $actual_link; ?>">

			<div class="col-md-1">
				<h5>
					<strong>Cliente</strong> <br><br>
					<?php echo $dados['nome']; ?>
					<?php if($avenca == 1){ echo '<div class="isavenca">A</div>'; } ?>
				</h5>
			</div>

			<div class="col-md-2"> <h5><strong>Título</strong> <br><br><?php echo $dados['titulo']; ?> </h5></div>

			<div class="col-md-3"> <h5><strong>Descrição</strong> <br><br><?php echo $corpo; ?> </h5></div>

			<div class="col-md-2">
			<h5><strong>Intervenientes</strong><br><br>
			<?php while($intervenientes= $interv->fetch(PDO::FETCH_ASSOC)){ ?>
					<img src="img/users/<?php echo $intervenientes['img'] ?>" class="img-circle" width="40px" title="<?php echo $intervenientes['nome_user'] ?>">
			 <?php } ?> 
			</h5></div>


			<div class="col-md-2"> <h5><strong>Data Limite</strong> <br><br><?php echo $newDateFim; ?> </h5></div>

			</a>
			<div class="col-md-2"> <h5><strong>Estado</strong> <br><br>
				<form method="POST" action="">
					<select class="form-control" name="estado" required>
					<option value="" disabled>Estado</option>
					<option <?php if($estado == 0){ echo "selected"; }?> value="0">Por Iniciar</option>
					<option <?php if($estado == 1){ echo "selected"; }?> value="1">Em Curso</option>
					<option <?php if($estado == 2){ echo "selected"; }?> value="2">Concluída</option>
					<option <?php if($estado == 3){ echo "selected"; }?> value="3">Pausa</option>
					<option <?php if($estado == 4){ echo "selected"; }?> value="4">Aguarda Aprovação Interna</option>
					<option <?php if($estado == 5){ echo "selected"; }?> value="5">Aguarda Aprovação Externa</option>
					</select>
					<br>
					<?php if($_SESSION ['admin']==1){ ?>
					<button type="submit" name="btnestado" id="btncheckestado" style="background-color:transparent; border:none;">
						<i class="fa fa-check" aria-hidden="true"></i>
					</button>
					<?php } ?>
					<input type="hidden" name="tarefaid" value="<?php echo $dados ['id_tarefa'];?>">
				</form>
			</div>

		
	
	</div>


<?php } ?>


</div>


</body>
</html>