<?php include('headers.php'); ?>

<title>INVISUAL - Projetos</title>

<style>

tr:hover{
	color:black !important;
}

</style>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer eliminar este Projeto e todas as Tarefas associadas? Esta ação é irreversível!');
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

<h3 class="page-header"><i class="fa fa-tasks icons-header" title="Projetos" aria-hidden="true"></i> &nbsp;Todos os Projetos marcados como Urgentes</h3>
<input type="checkbox" id="alternar-estado"><label for="alternar-estado"> &nbsp; Mostrar Tarefas Já Concluídas</label>

<?php 
$obj = new classes_DbManager ();


$dado = $obj->listarTarefasUrg();


while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
$corpo = $dados['descricao'];
$corpo = substr($corpo,0,75);
$urg = $dados['urgente'];
$estado = $dados['estado'];
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



		<div class="row row-list estado-<?php echo $estado ?>" style="margin: 5vh auto;<?php if($estado==2){echo "border-bottom:4px solid black !important;";}?><?php if($urg==1){echo "border-bottom:4px solid red;";}?>">

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

					<div class="col-md-1"> <h5><strong>Prioridade</strong></h5><h5 style="color:<?php echo $dados['cor_prioridade'];?> !important"><?php echo $dados['nome_prioridade']; ?> </h5></div>

					<div class="col-md-1"> <h5><strong>Estado</strong> <br><br><a <?php if($_SESSION['admin']==1){?> href = "estado.php?id=<?php echo $dados['id_tarefa']; ?>&state=<?php echo $estado ?>"<?php } else{?> href="#" <?php } ?>><button style="font-size:.9em;" type="button" class="btn btn-primary"><?php echo $state ?></button></a></h5> </div>

				</a>
			
		</div>


<?php } ?>





</div>


</body>
</html>