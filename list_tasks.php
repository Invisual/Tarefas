<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>


<style>

.row-list:hover{
	    box-shadow: 0 1px 2px rgba(0,0,0,.1) !important;
		top:0;
}

<?php if($_SESSION['admin'] == 1){ ?>
<?php } ?>

</style>

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

<h3 class="page-header"><i class="fa fa-thumb-tack icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp;<strong>Tarefas</strong> de Todos os Colaboradores</h3>

<?php



$obj = new classes_DbManager ();
$dado = $obj-> listTasks();

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
$corpo = $dados['descricao_task'];
$corpo = substr($corpo,0,75);
$concluido = $dados['concluido_task'];
$link = $_SERVER['PHP_SELF'];
if($concluido == 0){
	$conc = "Não";
}
else if($concluido == 1){
	$conc = "Sim ";
}
else if($concluido == 2){
	$conc = "Em processamento ";
}
 ?>
 
 
 	 <div class="row row-list" style="margin: 5vh auto;">

		<div class="col-md-2"><h5><strong>Título do Projeto</strong> <br><br><?php echo $dados['titulo']; ?> </h5></div>

		<div class="col-md-2"><h5><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h5></div>

		<div class="col-md-3"><h5><strong>Descrição da Tarefa</strong> <br><br><?php echo $corpo; ?> </h5>
		<?php if($_SESSION['admin'] == 1){ ?>
		<a href="edit_task.php?id=<?php echo $dados['id_task']; ?>"><i class="fa fa-wrench" aria-hidden="true"></i></a><?php } ?>
		</div>

		<div class="col-md-2">
		<h5><strong>Colaborador</strong> <br><br><img src='img/users/<?php echo $dados['img'];?>' class='img-circle img-colab' width='35px'><br>
		<?php echo $dados['nome_user']; ?> </h5>
		</div>

		<div class="col-md-1">
		<h5><strong>Projeto</strong>  <br><br><a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']; ?>">
		<button type="button" class="btn btn-info">Ver</button></a></h5>
		</div>

		<div class="col-md-1">
		<h5><strong>Prioridade</strong> <br><br><p style="color:<?php echo $dados['cor_prioridade']; ?>;">
		<?php echo $dados['nome_prioridade']; ?></p></h5>
		</div>

		<div class="col-md-1"><h5><strong>Concluída</strong> <br><br><?php echo $conc; ?></h5> </div>

	</div>


<?php } ?>


</div>


</body>
</html>