<?php include('headers.php'); ?>

<title>INVISUAL - Clientes</title>


<style>

tr:hover{
	color:black !important;
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



?>


<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-users icons-header" title="Clientes" aria-hidden="true"></i> &nbsp;Todos os <strong>Clientes</strong></h3>

<?php

$obj = new classes_DbManager ();
$dado = $obj-> listarClientes();

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
$countTarefas = $obj->contarTarefasCliente($dados['id_cliente']);


 ?>
 
 <?php 
  if($_SESSION['admin'] == 1){ ?>
	<div class="row row-list" style="margin: 5vh auto;">

		<div class="col-md-3"><h5><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h5></div>
		<div class="col-md-3"><h5><strong>Tarefas</strong> <br><br><?php echo $countTarefas; ?> </h5></div>
		<div class="col-md-3"><h5><strong>Ver Tarefas</strong>  <br><br><a href = "list_tarefas.php?cliente=<?php echo $dados['id_cliente']; ?>"><button type="button" class="btn btn-info">Ver</button></a></h5></div>
		<div class="col-md-3"><h5><strong>Eliminar Cliente</strong> <br><br><a href = "delete_cliente.php?cliente=<?php echo $dados['id_cliente']; ?>" onclick="return checkDelete()"><button type="button" class="btn btn-danger">X</button></a></h5> </div>

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