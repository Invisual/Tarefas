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
	cursor:pointer;
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
	font-size: 16px;
    color: #797676;
	padding-bottom: 55px;
	padding-left: 20px;
}

.botoes-tarefa{
	position: absolute;
    top: 8px;
    right: 15px;
}

.primeira-row-tarefa, .blocks-tarefa .col-md-12{
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

.meta-tarefa{
	position: absolute;
    bottom: 2px;
    right: 15px;
}

.meta-tarefa h5{
	display: inline-block;
    color: #bbb6b6;
    font-weight: 600;
    margin-left: 25px;
    font-size: 1em;
    letter-spacing: .01em;
}

.meta-tarefa i{
	margin-right:8px;
	color:#797777;
}

.iconprocessada {
	margin-left: 15px;
	color:#fff !important;
}

.botoes-tarefa-mobile{
	display:none;
}

.add-hora-custom{
	position:absolute;
	right:10px;
	bottom:-14px;
}

.add-hora-custom a{
	font-size: 45px;
    font-weight: 500;
    color: #2196f3;
}

.modal-tarefa{
	margin: auto;
  	position: absolute;
  	top: 25%; 
	left: 0;
	right: 0;
	background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 -5px 15px rgba(0,0,0,0.16), 0 22px 16px rgba(0,0,0,0.23);
    width: 40%;
	padding: 30px 25px 20px 25px;
	text-align:center;
	opacity:0;
	display:none;
}

.mostrar-modal{
	display:block;
	animation: mostrarModal .3s ease-in;
	animation-fill-mode: forwards;
}

@keyframes mostrarModal{
	0%{
		opacity:0;
	}
	100%{
		opacity:1;
	}
}

.close-modal{
	position: absolute;
    right: 11px;
    top: 6px;
    font-weight: 800;
    font-size: 1.2em;
    color: #666;
	cursor:pointer;
}

.modal-tarefa label{
	display:block;
	text-align:left;
	width:90%;
	margin:0 auto 10px auto;
	color: #666;
    letter-spacing: .02em;
}

.modal-tarefa textarea{
	width:90%;
	margin:0 auto;
	border-radius: 7px;
    background-color: #f7f7f7;
    border: none;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    text-indent: 15px;
	height:70px;
}

.modal-tarefa button{
	font-weight: 600;
    letter-spacing: .02em;
    border-radius: 7px;
}

.icon-registo-custos{
	padding:0 !important;
}

.preenchido{
	padding: 7px !important;
    border-radius: 2px;
    background-color: #2196f3;
    margin-left: 15px;
}

.preenchido i{
	color:#fff;
	padding:0;
}

.alerta-modal{
	font-size:12px;
	margin: 15px 0 0 0;
}

.mt0{
	margin-top:0 !important;
}

.mt20{
	margin-top:20px !important;
}

.mb10{
	margin-bottom:10px;
}

.mb5{
	margin-bottom:5px;
}

.col-center{
	text-align:center;
}

table{
	width:98% !important;
}
textarea, select, input, button { outline: none; }

@media screen and (max-width: 767px){
	.modal-tarefa {
		width:85%;
	}
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
$registosfaturacoes = $obj -> registosFaturacoes($idtarefa);
$contarRegistoCustos = $obj -> contarRegistosCustosTarefa($idtarefa);
$registoCustos = $obj -> listarRegistosCustosTarefa($idtarefa);
$registoConcluida = $obj -> registosConcluida($idtarefa);


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
	$faturada = $dados['faturada'];
	$avenca = $dados['avenca'];
	$diaria = $dados['diaria'];
	$foifaturada = $dados['foi_faturada'];
	$observacoesFaturacao = $dados['observacoes_faturacao'];
	$tipotarefa = $dados['tipo_tarefa'];
	$newValAvenca = !$avenca;
	if($avenca==1){
		$newValAvenca = 0;
	}
	else{
		$newValAvenca = 1;
	}
}


while($dados= $registosfaturacoes->fetch(PDO::FETCH_ASSOC)){
	$dataRegistoFaturacao = $dados['data'];
	$userRegistoFaturacao = $dados['nome_user'];
	$dia = substr($dataRegistoFaturacao, 8, 2);
	$mes = substr($dataRegistoFaturacao, 5, 2);
	$ano = substr($dataRegistoFaturacao, 0, 4);
	$dataCompleta = $dia.'/'.$mes.'/'.$ano;
}


while($dados= $registoConcluida->fetch(PDO::FETCH_ASSOC)){
	$dataRegistoConcluida = $dados['data'];
	$userRegistoConcluida = $dados['nome_user'];
	$diaC = substr($dataRegistoConcluida, 8, 2);
	$mesC = substr($dataRegistoConcluida, 5, 2);
	$anoC = substr($dataRegistoConcluida, 0, 4);
	$dataCompletaConcluida = $diaC.'/'.$mesC.'/'.$anoC;
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

switch($faturada){
	case '0':
	$faturadaName = 'Para Faturar';
	break;

	case '1':
	$faturadaName = 'Faturada';
	break;

	case '2':
	$faturadaName = 'Em Avença';
	break;

	case '3':
	$faturadaName = 'Em Análise';
	break;

	case '4':
	$faturadaName = 'Gratuita';
	break;

	default:
	$faturadaName = '-';
	break;
}

switch($tipotarefa){
	case '0':
	$nameTipo = 'Tarefa Normal';
	break;

	case '1':
	$nameTipo = 'Tarefa Diária';
	break;

	case '2':
	$nameTipo = 'Tarefa Externa';
	break;
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
						<span <?php if($processada == 0){ echo 'onclick="return processarTarefa()"';}?> class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">C</span>
						<?php if($processada == 1 && $_SESSION['superadmin']==1){ ?>
								<span <?php if($foifaturada == 0){ echo "onclick='return faturarTarefa(".$idtarefa.",".$foifaturada.")'";}?> class="pgrande <?php if($foifaturada == 1){ ?>iconprocessada <?php } ?>"title="Marcar como Faturada">F</span>
						<?php } ?>
						<?php if($contarRegistoCustos > 0 && $faturada != 2) {?>
							<a href="editar_custos_tarefa.php?id=<?php echo $idtarefa ?>"><span class="icon-registo-custos preenchido"><i class="fas fa-file-invoice-dollar"></i></span></a>
						<?php } else if($faturada != 2){?>
							<a href="insert_custos_tarefa.php?id=<?php echo $idtarefa ?>"><span class="icon-registo-custos"><i class="fas fa-file-invoice-dollar"></i></span></a>
						<?php } ?>
						<a href = "copy_tarefa.php?id=<?php echo $idtarefa ?>" onclick="return checkCopy()"><i class="fa fa-copy" aria-hidden="true" title="Copiar Tarefa"></i></a>
						<a href = "edit_tarefa.php?id=<?php echo $idtarefa ?>"><i class="fa fa-wrench" aria-hidden="true" title="Editar Tarefa"></i></a>
						<a href = "delete_tarefa.php?id=<?php echo $idtarefa ?>" onclick="return checkDelete()"><i class="fa fa-trash-o" aria-hidden="true" title="Apagar Tarefa"></i></a>
				</div>
			<?php } ?>

			<div class="row primeira-row-tarefa">
					<h3 class="header-tarefa"><?php echo $titulo ?></h3>
					<br>
					<div class="desc-tarefa"><?php echo $desc ?></div>


					<?php if($_SESSION['admin']==1){ ?>
						<div class="botoes-tarefa">
							<span <?php if($processada == 0){ echo 'onclick="return processarTarefa()"';}?> class="pgrande <?php if($processada == 1){ ?>iconprocessada <?php } ?>"title="Para Processar">C</span>
							<?php if($processada == 1 && $_SESSION['superadmin']==1){ ?>
								<span onclick='return faturarTarefa(<?php echo $idtarefa.",".$foifaturada ?>)' class="pgrande <?php if($foifaturada == 1){ ?>iconprocessada <?php } ?>"title="Marcar como Faturada">F</span>
							<?php } ?>
							<?php if($contarRegistoCustos > 0 && $faturada != 2) {?>
							<a href="editar_custos_tarefa.php?id=<?php echo $idtarefa ?>"><span class="icon-registo-custos preenchido"><i class="fas fa-file-invoice-dollar"></i></span></a>
							<?php } else if($faturada != 2){?>
								<a href="insert_custos_tarefa.php?id=<?php echo $idtarefa ?>"><span class="icon-registo-custos"><i class="fas fa-file-invoice-dollar"></i></span></a>
							<?php } ?>
							<a href = "copy_tarefa.php?id=<?php echo $idtarefa ?>" onclick="return checkCopy()"><i class="fa fa-copy" aria-hidden="true" title="Copiar Tarefa"></i></a>
							<a href = "edit_tarefa.php?id=<?php echo $idtarefa ?>"><i class="fa fa-wrench" aria-hidden="true" title="Editar Tarefa"></i></a>
							<a href = "delete_tarefa.php?id=<?php echo $idtarefa ?>" onclick="return checkDelete()"><i class="fa fa-trash-o" aria-hidden="true" title="Apagar Tarefa"></i></a>
						</div>
					<?php } ?>
					<?php if($avenca == 1){?>
						<h5 class="tarefa-avenca">Tarefa Avençada</h4>
					<?php } ?>
					<div class="meta-tarefa">
						<h5 class="tarefa-tipo"><i class="fa fa-info"></i><?php echo $nameTipo; ?></h5>
						<h5 class="tarefa-cliente"><i class="fa fa-users"></i><?php echo $cliente; ?></h5>
						<h5 class="data-tarefa"><i class="fa fa-calendar"></i><?php echo $newDateFim;?></h5>
						<h5 class="estado-tarefa"><i class="fa fa-tasks"></i><?php echo $state?></h5>
						<h5 class="faturacao-tarefa"><i class="fa fa-credit-card"></i><?php echo $faturadaName?></h5>
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
						
						<?php if($_SESSION['superadmin']==1){?>
							<div class="add-hora-custom">
								<a href="adicionarhoras.php?idtarefa=<?php echo $idtarefa ?>">+</a>
							</div>	
						<?php } ?>
									
					</div>

					<div class="col-md-2"></div>

					<div class="col-md-5 block-horas-totais">
						<h4 class="blocks-title">Horas Totais</h4>
						<p class="horas-totais-trabalhadas"><?php echo $horasdetodos.'h:'.$minutosdetodos.'m';?></p>
					</div>

				</div>
				
				<?php if($_SESSION['admin']==1 && $faturada != 2){ ?>
				<div class="row">

					<div class="col-md-12 block-custos-faturacao">
						<h4 class="blocks-title">Custos para Faturação</h4>
						<?php
							if($contarRegistoCustos){
								$custoTotalFornecedor = 0;
								$custoTotalVenda = 0;
								$i = 1;
								echo '<table class="table">
										<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Serviço</th>
											<th style="text-align:center;" scope="col">Custos Fornecedor</th>
											<th style="text-align:center;" scope="col">Valores Venda</th>
										</tr>
										</thead>
										<tbody>';
								while($dados = $registoCustos->fetch(PDO::FETCH_ASSOC)){
									echo '<tr>
											<th scope="row">'.$i.'</th>
											<td>'.$dados['servico'].'</td>
											<td style="text-align:center;font-family: sans-serif;">'.$dados['custo_fornecedor'].'</td>
											<td style="text-align:center;font-family: sans-serif;">'.$dados['custo_venda'].'</td>
										</tr>';
									$custoTotalFornecedor += $dados['custo_fornecedor'];
									$custoTotalVenda += $dados['custo_venda'];
									$i++;
								}
								$resultado = $custoTotalVenda - $custoTotalFornecedor;
								echo '<tr>
											<th scope="row"></th>
											<td></td>
											<td style="text-align:center;"><strong>Total</strong></td>
											<td style="text-align:center;"><strong>Total</strong></td>
										</tr>
										<tr>
											<th scope="row"></th>
											<td></td>
											<td style="text-align:center;font-family: sans-serif;">'.$custoTotalFornecedor.'€</td>
											<td style="text-align:center;font-family: sans-serif;">'.$custoTotalVenda.'€</td>
										</tr>
										<tr>
											<th scope="row"></th>
											<td></td>
											<td></td>
											<td style="text-align:center;"><strong>Resultado</strong></td>
										</tr>
										<tr>
											<th scope="row"></th>
											<td></td>
											<td></td>
											<td style="text-align:center;font-family: sans-serif;">'.$resultado.'€</td>
										</tr>
										</tbody>
										</table>
										';
									}
							else{
								echo 'Esta Tarefa ainda não tem um Registo de Custos associado.';
							}	
						?>
					</div>
					
				</div>

				<div class="row">

					<div class="col-md-12 block-observacoes-faturacao">
						<h4 class="blocks-title">Observações para Faturação</h4>
						<p>
							<?php if($observacoesFaturacao == ''){echo 'Esta Tarefa não tem qualquer Observação para Faturação.';}
							else{echo $observacoesFaturacao;} ?>
						</p>
					</div>

				</div>
				<?php if($dataRegistoConcluida){ echo "<h6 class='frase-faturacao-tarefa'>Esta tarefa foi marcada como 'Concluída' por ".$userRegistoConcluida." no dia ".$dataCompletaConcluida.".</h6>"; }?>
				<?php if($dataRegistoFaturacao){ echo "<h6 class='frase-faturacao-tarefa'>Esta Tarefa foi Faturada por ".$userRegistoFaturacao." no dia ".$dataCompleta.".</h6>"; }?>
				<?php } ?>

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


<div class="modal-tarefa modal-tarefa-processada">
	<div class="close-modal">X</div>
	<form method="POST" action="processar_tarefa.php" class="form-processar-tarefa">
		<div class="form-group form-input-last">
			<label for="observacoes">Observações</label>
	    	<textarea name="observacoes" id="observacoes"></textarea>
		</div>
		<input type="hidden" name="idtarefa" value="<?php echo $idtarefa ?>" />
		<input type="hidden" name="valfaturada" value="<?php echo $faturada ?>" />
		<input type="hidden" name="titulotarefa" value="<?php echo $titulo ?>" />
		<input type="hidden" name="user" value="<?php echo $iduser ?>" />
		<input type="hidden" name="tipo" value="1"/>
		<div class="form-group">
			<button class="btn btn-primary">Concluir Tarefa</button>
		</div>
	</form>
</div>



</div>

<script>


	function processarTarefa(){
		var contarRegistoCustos = "<?php echo $contarRegistoCustos; ?>";
		var idtarefa = "<?php echo $idtarefa; ?>";
		var modoFaturacao = "<?php echo $faturada; ?>";

        if(modoFaturacao == 3){
			alert("O modo de Faturação desta Tarefa está definido como 'Em Análise'. Tem que alterar isto para poder marcar a Tarefa como 'Concluída'.")
		}
		else{
			$('.modal-tarefa').addClass('mostrar-modal');
			if(contarRegistoCustos == 0){
				$('.modal-tarefa form').append('<p class="alerta-modal">Esta Tarefa não tem nenhum Registo de Custos associado. Pode adicionar um <a href="insert_custos_tarefa.php?id='+idtarefa+'">aqui</a>.</p>')
			}
		}
		
	}




	function faturarTarefa(tarefa, val){
      var newVal = 0;
      var valFaturada = 0;
      val == 0 ? newVal = 1 : newVal = 0;
      val == 0 ? valFaturada = 1 : valFaturada = 0;
      $.ajax({
            type:'GET',
            url:'./ajax/faturar-tarefa.php',
            data: { 'id': tarefa, 'val': newVal, 'faturada': valFaturada  },
            success: function(){
				if(newVal == 1){
					alert("Esta Tarefa foi actualizada como 'Faturada'!");
				}
                else{
					alert("Esta Tarefa foi actualizada como 'Por Faturar'!");
				}
                location.reload()
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                alert('Algo correu mal! Tente de novo por favor.');
            }	
        });
  	}

	$('.close-modal').on('click', function(){
		$('.modal-tarefa').removeClass('mostrar-modal');
	})
</script>

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