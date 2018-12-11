<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>

<style>
    
    #alternar-estado{
        padding-left:3vw;
    }

	.tipo-2{
		border-bottom: 8px solid #2196f3;
	}
    
</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

$idutilizador = $_GET['iduser'];

$obj = new classes_DbManager ();

$getUser = $obj-> getUser($idutilizador);


$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$varconc = 0;

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

<?php 

while($dadosuser= $getUser->fetch(PDO::FETCH_ASSOC)){
	$username = $dadosuser['nome_user'];
	$userimg = $dadosuser['img'];
}
?>


<div class="container-fluid" style="position:relative; top:10vh;">


<h3 class="page-header">
	<img src="img/users/<?php echo $userimg; ?>" width="40px" class="img-circle" />
	&nbsp;
	Todas as <strong>Tarefas</strong> de <strong><?php echo $username ?></p></strong>
</h3>

<?php if(isset($_GET['conc'])){
	if($_GET['conc'] == 1){
		$mostrarConc = true;
	}
} ?>

<input type="checkbox" id="alternar-estado" <?php if($mostrarConc){ echo 'checked'; }?>>
<label for="alternar-estado"> &nbsp; Mostrar Tarefas Já Concluídas</label>

<?php




$dado = $obj-> listarTarefasUser($idutilizador);


while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
$corpo = $dados['descricao'];
$corpo = substr($corpo,0,75);
$urg = $dados['urgente'];
$estado = $dados['estado'];
$ordem = $dados['valor_ordem'];
$process = $dados['processada'];
$diaria = $dados['diaria'];
$tipo = $dados['tipo_tarefa'];
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

<?php if($diaria == 0){ ?>

<div class="row row-list estado-<?php echo $estado ?> tipo-<?php echo $tipo ?>" style="margin: 5vh auto;<?php if($estado==2){echo "border-bottom:4px solid black !important;";}?><?php if($process==1){echo "border-bottom:4px solid #5093e1 !important;";}?><?php if($urg==1){echo "border-bottom:4px solid red";}?>">

		<a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']; ?>&link=<?php echo $actual_link; ?>">

			<div class="col-md-1"> <h5><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h5></div>

			<div class="col-md-2"> <h5><strong>Título</strong> <br><br><?php echo $dados['titulo']; ?> </h5></div>

			<div class="col-md-3"> <h5><strong>Descrição</strong> <br><br><?php echo $corpo; ?> </h5></div>

			<div class="col-md-2">
			<h5><strong>Intervenientes</strong><br><br>
			<?php while($intervenientes= $interv->fetch(PDO::FETCH_ASSOC)){ ?>
					<img src="img/users/<?php echo $intervenientes['img'] ?>" class="img-circle" width="40px" title="<?php echo $intervenientes['nome_user'] ?>">
			 <?php } ?> 
			</h5></div>


			<div class="col-md-1"> <h5><strong>Data Limite</strong> <br><br><?php echo $newDateFim; ?> </h5></div>
			</a>
			<div class="col-md-1"> <h5><strong>Ordem</strong></h5>
			<form method="POST" action="mudar_ordem.php">
					<select class="form-control" name="ordem" required>
					<option value="" disabled>Ordem</option>
					<option <?php if($ordem == '1º'){ echo "selected"; }?> value="1º">1º</option>
					<option <?php if($ordem == '2º'){ echo "selected"; }?> value="2º">2º</option>
					<option <?php if($ordem == '3º'){ echo "selected"; }?> value="3º">3º</option>
					<option <?php if($ordem == '4º'){ echo "selected"; }?> value="4º">4º</option>
					<option <?php if($ordem == '5º'){ echo "selected"; }?> value="5º">5º</option>
					<option <?php if($ordem == '6º'){ echo "selected"; }?> value="6º">6º</option>
					<option <?php if($ordem == '7º'){ echo "selected"; }?> value="7º">7º</option>
					<option <?php if($ordem == '8º'){ echo "selected"; }?> value="8º">8º</option>
					<option <?php if($ordem == '9º'){ echo "selected"; }?> value="9º">9º</option>
					<option <?php if($ordem == '10º'){ echo "selected"; }?> value="10º">10º</option>
					<option <?php if($ordem == 'A definir'){ echo "selected"; }?> value="A definir">A definir</option>
					</select>
					<br>
					<?php if($_SESSION ['admin']==1){ ?>
					<button type="submit" name="btnordem" id="btncheckordem" style="background-color:transparent; border:none;">
						<i class="fa fa-check" style="position:relative; bottom:10px;" aria-hidden="true"></i>
					</button>
					<?php } ?>
					<input type="hidden" name="idtarefa" value="<?php echo $dados ['id_tarefa'];?>">
					<input type="hidden" name="iduser" value="<?php echo $idutilizador;?>">
				</form>
			</div>

			<div class="col-md-2"> <h5><strong>Estado</strong> <br><br>
				<form method="POST" action="mudar_estado.php">
					<select class="form-control" name="estado" required>
					<option value="" disabled>Estado</option>
					<option <?php if($estado == 0){ echo "selected"; }?> value="0">Por Iniciar</option>
					<option <?php if($estado == 1){ echo "selected"; }?> value="1">Em Curso</option>
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

<?php } else if($tipo == 1){?>

	<div class="row row-list estado-<?php echo $estado ?>" style="border-bottom: 8px solid #ffe631; height:85px; margin: 5vh auto;<?php if($estado==2){echo "border-bottom:4px solid black !important;";}?><?php if($process==1){echo "border-bottom:4px solid #5093e1 !important;";}?><?php if($urg==1){echo "border-bottom:4px solid red";}?>">

		<a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']; ?>">

			<div class="col-md-1"> <h5><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h5></div>

			<div class="col-md-2"> <h5><strong>Título</strong> <br><br><?php echo $dados['titulo']; ?> </h5></div>

			<div class="col-md-3"> <h5><strong>Descrição</strong> <br><br><?php echo $corpo; ?> </h5></div>

			<div class="col-md-2">
			<h5><strong>Intervenientes</strong><br><br>
			<?php while($intervenientes= $interv->fetch(PDO::FETCH_ASSOC)){ ?>
					<img src="img/users/<?php echo $intervenientes['img'] ?>" class="img-circle" width="40px" title="<?php echo $intervenientes['nome_user'] ?>">
			 <?php } ?> 
			</h5></div>


			<div class="col-md-1"> <h5><strong>Data Limite</strong> <br><br><?php echo $newDateFim; ?> </h5></div>
			</a>
			<div class="col-md-1"> <h5><strong>Ordem</strong>
				<br><br> Tarefa Diária </h5>
			</div>

			<div class="col-md-2"> <h5><strong>Estado</strong> <br><br>
				<form method="POST" action="mudar_estado.php">
					<select class="form-control" name="estado" required style="height:30px !important; width:60%;float: left; display: inline-block;">
					<option value="" disabled>Estado</option>
					<option <?php if($estado == 0){ echo "selected"; }?> value="0">Por Iniciar</option>
					<option <?php if($estado == 1){ echo "selected"; }?> value="1">Em Curso</option>
					<option <?php if($estado == 3){ echo "selected"; }?> value="3">Pausa</option>
					<option <?php if($estado == 4){ echo "selected"; }?> value="4">Aguarda Aprovação Interna</option>
					<option <?php if($estado == 5){ echo "selected"; }?> value="5">Aguarda Aprovação Externa</option>
					</select>
					<br>
					<?php if($_SESSION ['admin']==1){ ?>
					<button type="submit" name="btnestado" id="btncheckestado" style="background-color:transparent; border:none; position:relative; bottom:5px; right:15px;">
						<i class="fa fa-check" aria-hidden="true"></i>
					</button>
					<?php } ?>
					<input type="hidden" name="tarefaid" value="<?php echo $dados ['id_tarefa'];?>">
				</form>
			</div>
	
	</div>


<?php } } ?>





</div>


</body>


</html>