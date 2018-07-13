<?php include('headers.php'); ?>

<title>INVISUAL - Clientes</title>


<style>

tr:hover{
	color:black !important;
}

.counter-horas{
	background-color: #e2e2e2;
    height: 15px;
    width: 90%;
    margin: 0 auto;
    border-radius: 6px;
	position:Relative;
	overflow:hidden;
}

.barra-horas{
    height: 100%;
    border-radius: 6px;
	position: absolute;
    left: 0;
    top: 0;
}

.pesquisa-tarefas-ajax {
    margin-left: 10px;
    height: 40px !important;
    border-radius: 3px !important;
    border: 1px solid #cccc;
    margin-right: 5px;
    text-indent: 10px;
    margin-bottom: 15px;
}

.btn-pesquisa-cliente {
    background-color: #5093e1;
    border: none;
    border-radius: 2px;
    color: #fff;
    height: 40px;
    width: 40px;
    transition: all .5s ease;
}

.input-mes{
	padding-left:3vw;
	margin-top:35px;
}

.input-mes form, .input-mes h4{
	display:inline-block;
}

.selected-month{
	background: #5093e1;
    color: #fff;
    padding: 10px;
    border-radius: 4px;
    letter-spacing: .05em;
}

</style>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer eliminar este Cliente? Vai eliminar todas as Tarefas associadas a este cliente. Esta ação é irreversível!');
}
</script>

<?php
;
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

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
if($_SESSION['logged_in']!=1){
	header('location:index.php');
}


if(empty($_POST['pesquisa-avenca-mes'])){
	$mes = date("m");
}
else{
	$mes = $_POST['mes'];
}

	switch ($mes){
	
		case '01':
		$nomemes = 'Janeiro';
		break;
	
		case '02':
		$nomemes = 'Fevereiro';
		break;
	
		case '03':
		$nomemes = 'Março';
		break;
	
		case '04':
		$nomemes = 'Abril';
		break;
	
		case '05':
		$nomemes = 'Maio';
		break;
								
		case '06':
		$nomemes = 'Junho';
		break;
	
		case '07':
		$nomemes = 'Julho';
		break;
	
		case '08':
		$nomemes = 'Agosto';
		break;
	
		case '09':
		$nomemes = 'Setembro';
		break;
	
		case '10':
		$nomemes = 'Outubro';
		break;
	
		case '11':
		$nomemes = 'Novembro';
		break;
	
		case '12':
		$nomemes = 'Dezembro';
		break;
	}


?>


<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-users icons-header" title="Clientes" aria-hidden="true"></i> &nbsp;Todos os <strong>Clientes Avençados</strong></h3>

<div class="input-mes">

	<form name="pesquisa" action="" method="POST">

			<select name="mes" class="pesquisa-tarefas-ajax" style="margin-left:10px;">
				<option disabled selected>Mês</option>
				<option value="01">Janeiro</option>
				<option value="02">Fevereiro</option>
				<option value="03">Março</option>
				<option value="04">Abril</option>
				<option value="05">Maio</option>
				<option value="06">Junho</option>
				<option value="07">Julho</option>
				<option value="08">Agosto</option>
				<option value="09">Setembro</option>
				<option value="10">Outubro</option>
				<option value="11">Novembro</option>
				<option value="12">Dezembro</option>
			</select>
			
			<input type="submit" name="pesquisa-avenca-mes" value="Ir" class="btn-pesquisa-cliente">
	</form>

	<h4 class="selected-month"><?php echo $nomemes; ?></h4>

</div>

<?php

$obj = new classes_DbManager ();

$dado = $obj-> listarClientesAvenca();

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){

$countTarefas = $obj->contarTarefasClienteAvenca($dados['id_cliente']);

$getHorasCliente = $obj->HorasClienteMes($dados['id_cliente'], $mes);

$hours = substr($getHorasCliente,0,2);
$minutes = substr($getHorasCliente,3,2);
$horasCliente = $hours.'h:'.$minutes.'m';
$horascertas = $hours.'.'.$minutes;
$horasWidth = 100*$horascertas / $dados['horas_mensais'];
if($horascertas > $dados['horas_mensais']){
	$bg = 'red';
}
else{
	$bg = '#5093e1';
}
 ?>
 
 <?php 
  if($_SESSION['admin'] == 1){ ?>
	<div class="row row-list" style="margin: 5vh auto;">

		<div class="col-md-2"><h5><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h5></div>
		<div class="col-md-2"><h5><strong>Tarefas Avençadas</strong> <br><br><?php echo $countTarefas; ?> </h5></div>
		<div class="col-md-2"><h5><strong>Ver Tarefas</strong><br><br><a href = "list_tarefas.php?cliente=<?php echo $dados['id_cliente']; ?>"><button type="button" class="btn btn-info">Ver</button></a></h5></div>
		<div class="col-md-4">
			<h5>
				<strong>Horas Mensais</strong>
				<br><br>
				<?php echo $horasCliente.' / '.$dados['horas_mensais'].'h';?>
			</h5>
			<div class="counter-horas"><div class="barra-horas" style="width:<?php echo $horasWidth; ?>%;background-color:<?php echo $bg; ?>;"></div></div>
		</div>
		<div class="col-md-2"><h5><strong>Eliminar Cliente</strong> <br><br><a href = "delete_cliente.php?cliente=<?php echo $dados['id_cliente']; ?>" onclick="return checkDelete()"><button type="button" class="btn btn-danger">X</button></a></h5> </div>

	</div>
  <?php } 
  else{ ?>

  	<div class="row row-list" style="margin: 5vh auto;">

		<div class="col-md-4"><h5><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h5></div>
		<div class="col-md-4"><h5><strong>Projetos</strong> <br><br><?php echo $countTarefas; ?> </h5></div>
		<div class="col-md-4"><h5><strong>Ver Projetos</strong>  <br><br><a href = "list_tarefas.php?cliente=<?php echo $dados['id_cliente']; ?>"><button type="button" class="btn btn-info">Ver</button></a></h5></div>

	</div>



<?php } } ?>


</div>


</body>
</html>