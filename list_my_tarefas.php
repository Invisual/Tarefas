<?php include('headers.php');
date_default_timezone_set('Europe/Lisbon');?>

<title>INVISUAL - Tarefas</title>

<style>
body.list-my-tarefas{
	font-family: 'Raleway', sans-serif;
}

h4{
	position:unset;
	margin:0;
	color: #5a5454;
    font-weight: 600;
    letter-spacing: .03em;
}

.titulo-tarefa-list{
	font-weight:700;
	line-height: 20px;
	width: 75%;
}

.tarefa-listagem{
	margin-top: 40px;
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding-bottom: 20px;
    min-height: 225px;
    position: relative;
    padding: 20px 10px 10px 22px;
	color: #333;
	width: 30%;
    margin-right: 1.5%;
	margin-left: 1.5%;
	overflow: hidden;
}

.cliente-tarefa-list{
    font-size: 1em;
	padding-right: 6px;
	color:#b1aeae;
}

.intervenientes-list{
	margin-top:33px;
	padding-left: 12px;
	padding-bottom: 50px;
}

.ordem-list{
	position: absolute;
    bottom: 11px;
    right: 15px;
}

.ordem-list h4{
	color:#b1aeae;
	font-size: 17px;
}

.titulo-e-cliente h3{
	font-size: 30px;
    font-family: sans-serif;
    color: #2196f3;
    font-weight: 600;
    padding: 0;
    margin: 0;
    position: relative;
    bottom: 7px;
}

.estado-list{
	position: absolute;
    bottom: -7px;
}

.estado-list form{
	width: 150px;
    display: inline-block;
}

.estado-list form select{
	border: none;
    box-shadow: none;

}

.estado-list form button{
	position: relative;
    top: 8px;
}

.estado-list form i{
	font-size: 16px;
	color:#2196f3;
}

#alternar-estado-list, #ae-list{
	position:absolute;
	right:50px;
}

#ae-list{
	right:75px;
}

h3 strong {
    color: #2196f3;
}

.icons-header {
    color: #2196f3 !important;
}

.estado-conc{
	border-top:10px solid #212121;
}

.hora-list{
    margin-top: 17px;
}

.hora-list h4{
	color: #b1aeae;
    font-size: 16px;
    padding-left: 15px;
	font-weight: 600;
}

.estado-conc{
	display:none;
}

.botoes-toggle-list{
	position: absolute;
    right: 30px;
    top: 0;
}

.botoes-toggle-list button{
	background-color: #2196f3;
    color: #fff;
    padding: 10px;
    font-weight: 600;
    border: none;
    margin-left: 20px;
    border-radius: 7px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 3px 6px rgba(0,0,0,0.13);
}

.titulo-list{
	margin-top: 19px;
    padding-left: 15px;
}

.hora-aberta h4 {
    color: #e51c23;
}

.botoes-horas{
	padding:0;
	display:inline-block;
	position: absolute;
    right: 15px;
    top: 50px;
}

.botoes-horas form{
	position:unset;
}

.hora-btn{
	border: none !important;
	background:transparent !important;
}

.hora-btn:hover{
	background:transparent !important;
}

.hora-btn:hover i{
	transform:rotate(360deg);
}

.hora-btn i{
	color: #2196f3;
    font-size: 26px;
	transition:all .3s ease;
}

.btn-hora-fim i{
	color:#e51c23;
}

</style>

<?php
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

<body class="list-my-tarefas">

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp; As Minhas <strong>Tarefas</strong></h3>

<div class="botoes-toggle-list">
	<button class="btn-toggle-list" onclick="show1();">Todas as Tarefas</button>
	<button class="btn-toggle-list" onclick="show2();">Apenas Tarefas Concluídas</button>
</div>

<div class="row">

<?php

$obj = new classes_DbManager ();
$iduser = $_SESSION['id'];
$dado = $obj-> listarMinhasTarefas($iduser);

$i = 0;

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
$estado = $dados['estado'];

if($estado != 2){
$corpo = $dados['descricao'];
$corpo = substr($corpo,0,75);
$urg = $dados['urgente'];

$diaria = $dados['diaria'];
$newDateIni = date("d-m-Y", strtotime($dados['data_ini']));
$newDateFim = date("d-m-Y", strtotime($dados['data_fim']));
$ordem = $dados['valor_ordem'];
$contarHoras = $obj -> contarHorasTarefas($dados['id_tarefa']);
$checkHoraAberta = $obj -> checkHoraAbertaTarefas($iduser, $dados['id_tarefa']);
$horas = substr($contarHoras, 0,2);
$minutos = substr($contarHoras, 3,2);
$horaCompleta = $horas.'h:'.$minutos.'m';
$i++;


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

	<a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']; ?>">

		<div class="col-md-4 tarefa-listagem estado-normal estado-<?php echo $estado; ?>" <?php if($diaria == 1){ echo "style='border-top:10px solid #feea3b;'";} ?>>

			<div class="row titulo-e-cliente">
				<div class="col-md-8">
					<h3><?php if( $ordem == 'A definir' || $ordem == 'Tarefa Diária'){ echo "-";} else {echo $ordem;}  ?></h3>		
				</div>
				<div class="col-md-4" style="text-align:right;">
					<h4 class="cliente-tarefa-list"><?php echo $dados['nome']; ?></h4>
				</div>
			</div>

			<div class="titulo-list">
				<h4 class="titulo-tarefa-list"><?php echo $dados['titulo']; ?></h4>
			</div>
			
			<div class="intervenientes-list">
				<?php while($intervenientes= $interv->fetch(PDO::FETCH_ASSOC)){ ?>
						<img src="img/users/<?php echo $intervenientes['img'] ?>" class="img-circle" width="40px" title="<?php echo $intervenientes['nome_user'] ?>">
				<?php } ?> 
			</div>


			<div class="ordem-list <?php if($checkHoraAberta == 1){?> hora-aberta <?php } ?>">
				<h4>
							<?php
							if($horaCompleta != 'h:m'){
							echo $horaCompleta;
							}
							else{
								echo "Sem horas";
							}
							?>
				</h4>
			</div>

			</a>


			<div class="estado-list">
				<form method="POST" action="">
					<div class="row row-form-list">
						<div class="col-md-10">
							<select class="form-control" name="estado" required>
								<option value="" disabled>Estado</option>
								<option <?php if($estado == 0){ echo "selected"; }?> value="0">Por Iniciar</option>
								<option <?php if($estado == 1){ echo "selected"; }?> value="1">Em Curso</option>
								<option <?php if($estado == 2){ echo "selected"; }?> value="2">Concluída</option>
								<option <?php if($estado == 3){ echo "selected"; }?> value="3">Pausa</option>
								<option <?php if($estado == 4){ echo "selected"; }?> value="4">Aguarda Aprovação Interna</option>
								<option <?php if($estado == 5){ echo "selected"; }?> value="5">Aguarda Aprovação Externa</option>
							</select>
						</div>
						<div class="col-md-2">
							<button type="submit" name="btnestado" id="btncheckestado" style="background-color:transparent; border:none;">
								<i class="fa fa-check" aria-hidden="true"></i>
							</button>
						</div>
					</div>					
					<input type="hidden" name="tarefaid" value="<?php echo $dados ['id_tarefa'];?>">
				</form>
			</div>


			<div class="botoes-horas">

				<form action="" method="POST">
						<?php
							$consultarhoras = $obj-> consultaHoras($iduser, $dados['id_tarefa']);
							$hi = '';
							$hf = '';
							while($consultahoras = $consultarhoras->fetch(PDO::FETCH_ASSOC)){
								$hi = $consultahoras['hora_inicio'];
								$hf = $consultahoras['hora_fim'];
						}
						if(!empty($hi) && !empty($hf)){?>
						<button name="inicio-<?php echo $dados['id_tarefa']?>" onclick="return RefreshWindow();" class="btn btn-primary hora-btn btn-hora-ini"><i class="fa fa-clock-o icon-notificacoes" aria-hidden="true"></i></button>
					<?php }
						else if(!empty($hi) && empty($hf)){?>
						<button name="fim-<?php echo $dados['id_tarefa']?>" class="btn btn-primary hora-btn btn-hora-fim"><i class="fa fa-clock-o icon-notificacoes" aria-hidden="true"></i></button>
					<?php } 
						else if(empty($hi) && empty($hf)){?>
						<button name="inicio-<?php echo $dados['id_tarefa']?>" onclick="return RefreshWindow();" class="btn btn-primary hora-btn btn-hora-ini"><i class="fa fa-clock-o icon-notificacoes" aria-hidden="true"></i></button>
					<?php } ?>
				</form>	

				<div>	
								<?php
									if(isset($_POST['inicio-'.$dados['id_tarefa']]))
									{
										$horastart = date('H:i');
										$dia = date('d/m');
										$iniciohora = $obj-> inicioHora($iduser, $dados['id_tarefa'], $horastart, $dia);
										
									}

									if(isset($_POST['fim-'.$dados['id_tarefa']]))
									{
										$horafim = date('H:i');
										$fimhora = $obj-> fimHora($iduser, $dados['id_tarefa'], $horafim);
										
									}
								?>

				</div>

			</div>

		</div>

		<?php
			if($i % 3 == 0){
				echo "</div><div class='row'>";
			}
		?>


<?php } 
	else if($estado == 2){

		$corpo = $dados['descricao'];
		$corpo = substr($corpo,0,75);
		$urg = $dados['urgente'];
		
		$diaria = $dados['diaria'];
		$newDateIni = date("d-m-Y", strtotime($dados['data_ini']));
		$newDateFim = date("d-m-Y", strtotime($dados['data_fim']));
		$ordem = $dados['valor_ordem'];
		$contarHoras = $obj -> contarHorasTarefas($dados['id_tarefa']);
		$checkHoraAberta = $obj -> checkHoraAbertaTarefas($iduser, $dados['id_tarefa']);
		$horas = substr($contarHoras, 0,2);
		$minutos = substr($contarHoras, 3,2);
		$horaCompleta = $horas.'h:'.$minutos.'m';
		
		
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
		
			<a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']; ?>">
		
				<div class="col-md-4 tarefa-listagem estado-conc ?>" id="conc" <?php if($diaria == 1){ echo "style='border-top:10px solid #feea3b;'";} ?>>
	
		
					<div class="row titulo-e-cliente">
						<div class="col-md-8">
							<h3><?php if( $ordem == 'A definir' || $ordem == 'Tarefa Diária'){ echo "-";} else {echo $ordem;}  ?></h3>
						</div>
						<div class="col-md-4" style="text-align:right;">
							<h4 class="cliente-tarefa-list"><?php echo $dados['nome']; ?></h4>
						</div>
					</div>

					<div class="titulo-list">
						<h4 class="titulo-tarefa-list"><?php echo $dados['titulo']; ?></h4>
					</div>
					
					<div class="intervenientes-list">
						<?php while($intervenientes= $interv->fetch(PDO::FETCH_ASSOC)){ ?>
								<img src="img/users/<?php echo $intervenientes['img'] ?>" class="img-circle" width="40px" title="<?php echo $intervenientes['nome_user'] ?>">
						<?php } ?> 
					</div>
		
					<div class="ordem-list <?php if($checkHoraAberta == 1){?> hora-aberta <?php } ?>">
						<h4>
								<?php
								if($horaCompleta != 'h:m'){
								echo $horaCompleta;
								}
								else{
									echo "Sem horas";
								}
								?>
						</h4>
					</div>
		
					</a>
		
					<div class="estado-list">
						<form method="POST" action="">
							<div class="row row-form-list">
								<div class="col-md-10">
									<select class="form-control" name="estado" required>
										<option value="" disabled>Estado</option>
										<option <?php if($estado == 0){ echo "selected"; }?> value="0">Por Iniciar</option>
										<option <?php if($estado == 1){ echo "selected"; }?> value="1">Em Curso</option>
										<option <?php if($estado == 2){ echo "selected"; }?> value="2">Concluída</option>
										<option <?php if($estado == 3){ echo "selected"; }?> value="3">Pausa</option>
										<option <?php if($estado == 4){ echo "selected"; }?> value="4">Aguarda Aprovação Interna</option>
										<option <?php if($estado == 5){ echo "selected"; }?> value="5">Aguarda Aprovação Externa</option>
									</select>
								</div>
								<div class="col-md-2">
									<button type="submit" name="btnestado" id="btncheckestado" style="background-color:transparent; border:none;">
										<i class="fa fa-angle-right" aria-hidden="true"></i>
									</button>
								</div>
							</div>					
							<input type="hidden" name="tarefaid" value="<?php echo $dados ['id_tarefa'];?>">
						</form>
					</div>
		
				</div>
	
		



<?php } } ?>

</div>


</div>


</body>
<script>
	function show1(){
		  var els = document.getElementsByClassName('estado-conc');
		  for(var i = 0; i<els.length; i++){
			els[i].style.display = 'none';
		  }

		  var els2 = document.getElementsByClassName('estado-normal');
		  for(var i = 0; i<els2.length; i++){
			els2[i].style.display = 'block';
		  }
	}
</script>


<script>
	function show2(){
		  var els = document.getElementsByClassName('estado-conc');
		  for(var i = 0; i<els.length; i++){
			els[i].style.display = 'block';
		  }

		  var els2 = document.getElementsByClassName('estado-normal');
		  for(var i = 0; i<els2.length; i++){
			els2[i].style.display = 'none';
		  }
	}
</script>

</html>