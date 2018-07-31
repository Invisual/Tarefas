<?php 
session_start();
if($_SESSION['logged_in']==0){
	header('location:index.php');
}
include('headers.php');
date_default_timezone_set('Europe/Lisbon');
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
$x = 0;
?>

<title>INVISUAL - Tarefas</title>


<style>

body{
	font-family: 'Raleway', sans-serif;
}


	.btn-primary{
	background-color: #2196f3 !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#fff !important;
	border:none !important;
    position:relative;
}

h5{
	font-size:1.1em;
	position:relative;
	left:4vw;	
}

.nodisplay{
	display:none;
}

.iconprocessada{
	padding:7px !important;
	border-radius:2px;
	background-color:#2196f3;
	color:#fff;
}

.pgrande{
	font-weight:700;
	padding-left:25px;
}

.icon-observacoes{
	padding-left:10px;
}

.tarefa-single{
	width: 94%;
    margin: 0 auto;
}

.header-tarefa{
	padding:0;
	margin:0;
	color: #5a5454;
    font-weight: 600;
    letter-spacing: .03em;
    padding-bottom: 25px;
	margin-top: 10px;
}

.desc-tarefa{
	font-size: 19px;
    color: #797676;
	padding-bottom: 20px;
}

.botoes-tarefa{
	text-align:right;
	padding-bottom: 20px;
}

.primeira-row-tarefa{
	margin-top:40px;
	background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding-bottom: 20px;
    min-height: 185px;
    position: relative;
    padding: 20px 10px 10px 22px;
	color: #333;
}

h4, h5{
	position:unset;
}

.blocks-tarefa .row .col-md-5{
	background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding-bottom: 20px;
	min-height: 185px;
    position: relative;
	padding: 10px 10px 10px 22px;
}

.blocks-tarefa{
	margin-top: 50px;
}

.blocks-tarefa .row{
	margin-top:40px;
}

.blocks-title{
	color: #2196f3;
    letter-spacing: .03em;
    padding-bottom: 20px;
	font-weight:600;
}

.img-user-tarefa{
	width:70px;
	margin-right: 10px;
    margin-left: 10px;
}

.block-intervenientes div{
	text-align:center;
}

.block-btn{
	position: absolute;
    right: 15px;
    top: 15px;
	border-radius: 11px;
}

.btn-hora-fim{
	background-color:#de0000 !important;
}

.img-observacao{
	border-radius:50%;
}

.horas-totais-trabalhadas{
	text-align: center;
    font-size: 3em;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
    color: #5a5454;
}

.botoes-tarefa i, .botoes-tarefa span, .botoes-tarefa-mobile i, .botoes-tarefa-mobile span{
	font-size:22px;
	padding-left: 15px;
	color:#2196f3;
}

.horas h5 strong {
    color: #333;
}

.img-user-horas{
	margin-right:15px;
}

.horas p{
	font-size: 14px;
    color: #797676;
    letter-spacing: .02em;

}

.horas strong{
	font-weight:600;
}

#conteudo-obs{
	padding-left: 10px;
    color: #797676;
}

.tarefa-cliente, .data-tarefa, .estado-tarefa, .tarefa-avenca{
	color: #5a5454;
	font-weight:600;
}

.iconprocessada {
	margin-left: 15px;
	color:#fff !important;
}

.botoes-tarefa-mobile{
	display:none;
}
</style>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer eliminar esta Tarefa? Esta ação é irreversível!');
}
</script>

<script language="JavaScript" type="text/javascript">
function checkCopy(){
    return confirm('Tem a certeza que quer copiar esta Tarefa?');
}
</script>


<script language="JavaScript" type="text/javascript">
function checkDeleteObservacao(){
    return confirm('Tem a certeza que quer eliminar esta Observação?');
}
</script>


<script language="JavaScript" type="text/javascript">
function checkProcessada(){
    return confirm('Trabalho para Processar.');
}
</script>
<script language="JavaScript" type="text/javascript">
function checkAvenca(){
    return confirm('Trabalho para Avença.');
}
</script>
<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');


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


// IR BUSCAR DADOS PARA LISTAR A TAREFA

$idtarefa = $_GET['id'];
$idnotificacao=$_GET['not'];
$iduser = $_SESSION['id'];

$obj = new classes_DbManager ();
$dado = $obj-> listTarefa($idtarefa);
$notificacaoVista = $obj -> notificacaoVista($idnotificacao, $iduser);
$usersTarefa = $obj-> usersTarefa($idtarefa);
$registoshoras = $obj-> registosHoras($idtarefa);

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
    $titulo = $dados['titulo'];
    $desc = $dados['descricao'];
    $dataini = $dados['data_ini'];
	$datafim = $dados['data_fim'];
    $cliente = $dados['nome'];
    $nomeuser = $dados['nome_user'];
	$estado = $dados['estado'];
	$prioridade = $dados['nome_prioridade'];
	$corprioridade = $dados['cor_prioridade'];
	$processada = $dados['processada'];
	$avenca = $dados['avenca'];
	$newValAvenca = !$avenca;
	if($avenca==1){
		$newValAvenca = 0;
	}
	else{
		$newValAvenca = 1;
	}
}

$newDateIni = date("d-m-Y", strtotime($dataini));
$newDateFim = date("d-m-Y", strtotime($datafim));

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
	$state = "Aguarda Aprovação Interna";
}
else if($estado == 5){
	$state = "Aguarda Aprovação Externa";
}


if(!empty($_POST['submit'])){
	$userobs = $iduser;
	$tarefaobs = $idtarefa;
	$textoobs = $_POST['texto-observacao'];

	try{		
		$log = new classes_UserManager($myControlPanel);
		$insertobs = $log->insertObservacao($userobs, $tarefaobs, $textoobs);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
}
?>


<?php include('navbar.php'); ?>
<body class="pagina-tarefa">

<div class="container-fluid" style="position:relative; top:6vh;">


	<div class="tarefa-single">
			
			<?php if($_SESSION['admin']==1){ ?>
				<div class="botoes-tarefa-mobile">
					<?php if(isset($_GET['link'])){?>
						<a href = "processar_tarefa.php?id=<?php echo $idtarefa ?>&val=1&link=<?php echo $_GET['link'].'&conc=1' ?>" onclick="return checkProcessada()"><span class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">P</span></a>
						<?php } else if(isset($_GET['linktodas'])){?>
							<a href = "processar_tarefa.php?id=<?php echo $idtarefa ?>&val=1&link=<?php echo $_GET['linktodas'].'?&conc=1' ?>" onclick="return checkProcessada()"><span class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">P</span></a>
						<?php }
						else{?>
							<a href = "processar_tarefa.php?id=<?php echo $idtarefa ?>&val=1" onclick="return checkProcessada()"><span class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">P</span></a>
						<?php } ?>
						<a href = "edit_tarefa.php?id=<?php echo $idtarefa ?>"><i class="fa fa-wrench" aria-hidden="true" title="Editar Tarefa"></i></a>
						<a href = "delete_tarefa.php?id=<?php echo $idtarefa ?>" onclick="return checkDelete()"><i class="fa fa-trash-o" aria-hidden="true" title="Apagar Tarefa"></i></a>
				</div>
			<?php } ?>

			<div class="row primeira-row-tarefa">

				<div class="col-md-6">
					<h3 class="header-tarefa"><?php echo $titulo ?></h3>
					<br>
					<p class="desc-tarefa"><?php echo $desc ?></p>
				</div>

				<div class="col-md-6" style="text-align:right;">
					<?php if($_SESSION['admin']==1){ ?>
						<div class="botoes-tarefa">
							<?php if(isset($_GET['link'])){?>
									<a href = "processar_tarefa.php?id=<?php echo $idtarefa ?>&val=1&link=<?php echo $_GET['link'].'&conc=1' ?>" onclick="return checkProcessada()"><span class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">P</span></a>
							<?php } else if(isset($_GET['linktodas'])){?>
								<a href = "processar_tarefa.php?id=<?php echo $idtarefa ?>&val=1&link=<?php echo $_GET['linktodas'].'?&conc=1' ?>" onclick="return checkProcessada()"><span class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">P</span></a>
							<?php }
							else{?>
							<a href = "processar_tarefa.php?id=<?php echo $idtarefa ?>&val=1" onclick="return checkProcessada()"><span class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">P</span></a>
							<?php } ?>
							<a href = "copy_tarefa.php?id=<?php echo $idtarefa ?>" onclick="return checkCopy()"><i class="fa fa-copy" aria-hidden="true" title="Copiar Tarefa"></i></a>
							<a href = "edit_tarefa.php?id=<?php echo $idtarefa ?>"><i class="fa fa-wrench" aria-hidden="true" title="Editar Tarefa"></i></a>
							<a href = "delete_tarefa.php?id=<?php echo $idtarefa ?>" onclick="return checkDelete()"><i class="fa fa-trash-o" aria-hidden="true" title="Apagar Tarefa"></i></a>
						</div>
					<?php } ?>
					<?php if($avenca == 1){?>
					<h5 class="tarefa-avenca">Tarefa Avençada</h4>
					<?php } ?>
					<h5 class="tarefa-cliente"><?php echo $cliente; ?></h4>
					<h5 class="data-tarefa"><?php echo $newDateFim;?></h4>
					<h5 class="estado-tarefa"><?php echo $state?></h4>
				</div>

			</div>



			<div class="blocks-tarefa">
							
				<div class="row">

					<div class="col-md-5 block-intervenientes">
						<h4 class="blocks-title">Intervenientes</h4>
						<div>
							<?php while($users= $usersTarefa->fetch(PDO::FETCH_ASSOC)){ ?>
							<img src="img/users/<?php echo $users['img']; ?>" class="img-circle img-user-tarefa" width="30px" title="<?php echo $users['nome_user']; ?>">
							<?php if($users['id_user'] == $iduser){ $x=1;}?>
							<?php } ?>
						</div>
					</div>

					<div class="col-md-2"></div>

					<div class="col-md-5 block-observacoes">
						<h4 class="blocks-title">Observações</h4>
						<div>

							<?php
							$observacoes = $obj-> listarObservacoes($idtarefa);
							while($obs= $observacoes->fetch(PDO::FETCH_ASSOC)){ ?>
								<p style="padding: 5px 0 5px 0;">
									<img src="img/users/<?php echo $obs['img']?>" title="<?php echo $obs['nome_user'] ?>" width="30px" class="img-observacao">
									<span id="conteudo-obs"> <?php echo $obs['texto']?></span>
									<?php if($iduser == $obs['id_user_observacao']){ ?>
									<span class="icon-observacoes"><a href="editar_observacao.php?idobs=<?php echo $obs['id_observacao'] ?>&idtarefa=<?php echo $idtarefa ?>"><i class="fa fa-wrench"></i></a></span>
									<span class="icon-observacoes"><a href="delete_observacao.php?idobs=<?php echo $obs['id_observacao'] ?>&idtarefa=<?php echo $idtarefa ?>" onclick="return checkDeleteObservacao	()"><i class="fa fa-trash"></i></a></span>
									<?php } ?>
								</p>
							<?php } ?>

							<button onclick="addObservacao()" class="btn btn-primary block-btn"><i class="fa fa-plus"></i></button>
							<div id="textarea-observacoes" style="width: 90%;margin: 20px auto 0 auto;"></div>

						</div>
					</div>

				</div>



				<div class="row">

					<div class="col-md-5 block-horas">
						<h4 class="blocks-title">Horas</h4>
						
						<?php if($x == 1){?>
							<div>	
								<?php
									if(isset($_POST['inicio']))
									{
										$horastart = date('H:i');
										$dia = date('d/m');
										echo "<h6>O tempo começou a contar. Hora: " . $horastart . "</h6><br>";
										$iniciohora = $obj-> inicioHora($iduser, $idtarefa, $horastart, $dia);
										
									}

									if(isset($_POST['fim']))
									{
										$horafim = date('H:i');
										echo "<h6>O tempo já não está a contar. Hora: " . $horafim . "</h6><br>";
										$fimhora = $obj-> fimHora($iduser, $idtarefa, $horafim);
										
									}
								?>

							</div>
						<?php } ?>



						<?php if($registoshoras !=0){?>
							<div class="horas">
									<?php $contarhoras = $obj-> contarHoras($idtarefa);
									$horasdetodos = '';
									$minutosdetodos = '';
									while($totalhoras = $contarhoras->fetch(PDO::FETCH_ASSOC)){
										$user = $totalhoras['nome_user'];
										$imguser = $totalhoras['img'];
										$horainicio = $totalhoras['hora_inicio'];
										$horaend = $totalhoras['hora_fim'];
										$diahoras = $totalhoras['dia'];
										$dateDiff = intval((strtotime($horaend)-strtotime($horainicio))/60);
										
										$hours = intval($dateDiff/60);
										$minutes = $dateDiff%60;
										
										$horasdetodos += $hours;
										$minutosdetodos += $minutes;

										if($minutosdetodos > 60){
											$horasdetodos += 1;
											$minutosdetodos -= 60;
										}
									?>
									<?php if(!empty($horaend)){?>
									<p style="padding: 5px 0 5px 0; font-size:14px;"><?php echo '<img src="img/users/'.$imguser.'" width="30px" title="'.$user.'" alt="'.$user.'" class="img-observacao img-user-horas"><strong>'.$diahoras.'</strong> : '.$horainicio.'h - '.$horaend.'h  |  <strong>'.$hours.'h:'.$minutes.'m</strong>'?><?php if($_SESSION['superadmin']==1){?><a href="editarhoras.php?idhora=<?php echo $totalhoras['id_hora'] ?>&idtarefa=<?php echo $totalhoras['tarefa_id'] ?>"><i class="fa fa-wrench" style="margin-left:20px;"></i></a><a href="delete_hora.php?idhora=<?php echo $totalhoras['id_hora'] ?>&idtarefa=<?php echo $totalhoras['tarefa_id'] ?>" onclick="return checkDeleteHora();"><i class="fa fa-trash" style="margin-left:20px;"></i></a><?php } ?></p>
									<?php }  } ?>
							</div>
						<?php } ?>
						<form action="" method="POST">
									<?php
										$consultarhoras = $obj-> consultaHoras($iduser, $idtarefa);
										$hi = '';
										$hf = '';
										while($consultahoras = $consultarhoras->fetch(PDO::FETCH_ASSOC)){
											$hi = $consultahoras['hora_inicio'];
											$hf = $consultahoras['hora_fim'];
											}
										if(!empty($hi) && !empty($hf)){?>
											<button name="inicio" onclick="return RefreshWindow();" class="btn btn-primary block-btn btn-hora-ini"><i class="fa fa-clock-o icon-notificacoes" aria-hidden="true"></i></button>
										<?php }
										else if(!empty($hi) && empty($hf)){?>
											<button name="fim" class="btn btn-primary block-btn btn-hora-fim"><i class="fa fa-clock-o icon-notificacoes" aria-hidden="true"></i></button>
										<?php } 
										else if(empty($hi) && empty($hf)){?>
											<button name="inicio" onclick="return RefreshWindow();" class="btn btn-primary block-btn btn-hora-ini"><i class="fa fa-clock-o icon-notificacoes" aria-hidden="true"></i></button>
										<?php } ?>
						</form>					
					</div>

					<div class="col-md-2"></div>

					<div class="col-md-5 block-horas-totais">
						<h4 class="blocks-title">Horas Totais</h4>
						<p class="horas-totais-trabalhadas"><?php echo $horasdetodos.'h:'.$minutosdetodos.'m';?></p>
					</div>

				</div>


			</div>




	</div>



	<div class="print-tarefa" style="display:none;">
		
		<h5><?php echo $titulo ?></h5>
		<h6>Cliente: <?php echo $cliente; ?></h6>
		<h6>Data: <?php echo $newDateFim;?></h6>
		<h6>Estado: <?php echo $state?></h6>
		<h6>Descrição: <?php echo $desc?></h6>
		<br>
		<h6>Intervenientes:</h6>
		<?php
		$usersTar = $obj-> usersTarefa($idtarefa);
		while($users= $usersTar->fetch(PDO::FETCH_ASSOC)){ ?>
			<p><?php echo $users['nome_user']; ?></p>
		<?php } ?>	
		<br>

		<h6>Observações: </h6>
			<?php
				$observacoes = $obj-> listarObservacoes($idtarefa);
				while($obs= $observacoes->fetch(PDO::FETCH_ASSOC)){ ?>
				<p style="padding: 5px 0 5px 0;">
					<strong><?php echo $obs['nome_user'] ?></strong>
					<span id="conteudo-obs"> <?php echo $obs['texto']?></span>´
				</p>
			<?php } ?>
		<br>

		<h6>Horas: </h6>
			<?php
				$contarhoras = $obj-> contarHoras($idtarefa);
				$horasdetodos = '';
				$minutosdetodos = '';
				while($totalhoras = $contarhoras->fetch(PDO::FETCH_ASSOC)){
					$user = $totalhoras['nome_user'];
					$imguser = $totalhoras['img'];
					$horainicio = $totalhoras['hora_inicio'];
					$horaend = $totalhoras['hora_fim'];
					$diahoras = $totalhoras['dia'];
					$dateDiff = intval((strtotime($horaend)-strtotime($horainicio))/60);
										
					$hours = intval($dateDiff/60);
					$minutes = $dateDiff%60;
										
					$horasdetodos += $hours;
					$minutosdetodos += $minutes;

					if($minutosdetodos > 60){
						$horasdetodos += 1;
						$minutosdetodos -= 60;
					}
			?>
			<?php if(!empty($horaend)){?>
				<p style="padding: 5px 0 5px 0; font-size:14px;">
					<?php echo '<strong>'.$user.' </strong>'.$diahoras.' : '.$horainicio.'h - '.$horaend.'h  |  <strong>'.$hours.'h:'.$minutes.'m</strong>'?></p>
			<?php }  } ?>
		<br>

		<h6>Horas Totais: </h6>
		<p><?php echo $horasdetodos.'h:'.$minutosdetodos.'m';?></p>
	</div>

<br>

<div class="row row-mensagens-tarefa" style="display:none;">
    <div class="col-md-12" style="text-align:center;">
        <a href="<?php echo 'mensagens.php?id='.$idtarefa.'&titulo='.$titulo.'&cliente='.$cliente ?>"><button class="btn btn-primary">Ver Mensagens</button></a>
    </div>
</div>



</div>

<script>
	function RefreshWindow()
{
         window.location.reload(true);
}
</script>
<script language="JavaScript" type="text/javascript">
function checkDeleteHora(){
    return confirm('Tem a certeza que quer eliminar este registo de Horas?');
}
</script>
<script>
	function addObservacao()
{
		 $('#textarea-observacoes').append('<form name="observacoes" method="POST"><textarea style="width:50%;" name="texto-observacao"></textarea><br><input name="submit" type="submit" class="btn btn-primary" value="Enviar"></form>');
}
</script>
</body>
</html>