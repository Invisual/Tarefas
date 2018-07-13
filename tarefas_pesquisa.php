<?php include('headers.php'); ?>

<title>INVISUAL - Pesquisa</title>



<style>

.row-list:hover{
	    box-shadow: 0 1px 2px rgba(0,0,0,.1) !important;
		top:0;
}

.isavenca{
		color: #5093e1;
    font-weight: 600;
    font-size: 22px;
    margin-top: 10px;
	}

</style>

<?php
;
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']!=1){
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
	


	try{		
		$log = new classes_UserManager($myControlPanel);
	
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}




?>


<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-thumb-tack icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp;<strong>Tarefas</strong> de Todos os Colaboradores</h3>


<input type="checkbox" id="alternar-estado"><label for="alternar-estado"> &nbsp; Mostrar Tarefas Já Concluídas</label>


<?php
if(!empty($_POST)){
	
	$search = $_POST['search'];
	$userid = $log->getUserIdByName($search);
	try{		
		$log = new classes_UserManager($myControlPanel);
		$procurar = $log->searchUserTasks($search);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}


}


while($dados= $procurar->fetch(PDO::FETCH_ASSOC)){
$corpo = $dados['descricao'];
$corpo = substr($corpo,0,75);
$urg = $dados['urgente'];
$estado = $dados['estado'];
$ordem = $dados['valor_ordem'];
$avenca = $dados['avenca'];
$newDateIni = date("d-m-Y", strtotime($dados['data_ini']));
$newDateFim = date("d-m-Y", strtotime($dados['data_fim']));

$myDb = new classes_DbManager;
$interv = $myDb->_myDb->prepare("Select * from intervenientes_tarefa INNER JOIN users on intervenientes_tarefa.user_interv_id=users.id_user where tarefa_interv_id = '$dados[id_tarefa]'");
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
 
 
 	<div class="row row-list estado-<?php echo $estado ?>" style="margin: 5vh auto;<?php if($estado==2){echo "border-bottom:4px solid black !important;";}?><?php if($urg==1){echo "border-bottom:4px solid red";}?>">

		<a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']; ?>">

			<div class="col-md-1">
				<h5>
					<strong>Cliente</strong> <br><br>
					<?php echo $dados['nome']; ?>
					<?php if($avenca == 1){ echo '<div class="isavenca">A</div>'; } ?>
				</h5>
			</div>

			<div class="col-md-2"> <h5><strong>Título</strong> <br><br><?php echo $dados['titulo']; ?> </h5></div>

			<div class="col-md-4"> <h5><strong>Descrição</strong> <br><br><?php echo $corpo; ?> </h5></div>

			<div class="col-md-2">
			<h5><strong>Intervenientes</strong><br><br>
			<?php while($intervenientes= $interv->fetch(PDO::FETCH_ASSOC)){ ?>
					<img src="img/users/<?php echo $intervenientes['img'] ?>" class="img-circle" width="40px" title="<?php echo $intervenientes['nome_user'] ?>">
			 <?php } ?> 
			</h5></div>


			<div class="col-md-1"> <h5><strong>Data Limite</strong> <br><br><?php echo $newDateFim; ?> </h5></div>
			</a>


			<div class="col-md-2"> <h5><strong>Estado</strong> <br><br>
				<form method="POST" action="mudar_estado.php">
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