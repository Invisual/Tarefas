<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas Diárias</title>

<style>
    .row-list{
        border-top:4px solid #2f323a;
    }
</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

$idusertar = $_GET['user'];


if(!empty($idusertar)){ $x = 1; } else { $x = 0; }


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

<?php if($x == 1){ ?>
<h3 class="page-header"><i class="fa fa-thumb-tack icons-header" style="color:#2f323a !important" title="Tarefas Diárias" aria-hidden="true"></i> &nbsp;As Minhas <strong style="color:#2f323a !important">Tarefas Diárias</strong></h3>
<?php }
else {?>
<h3 class="page-header"><i class="fa fa-thumb-tack icons-header" style="color:#2f323a !important" title="Tarefas Diárias" aria-hidden="true"></i> &nbsp; Todas as <strong style="color:#2f323a !important">Tarefas Diárias</strong></h3>
<?php }

$link = $_SERVER['REQUEST_URI'];

$obj = new classes_DbManager ();

if($x == 1){
	$dado = $obj-> listarTarefasDiarias($idusertar);
}
else{
	$dado = $obj-> listarTarefasDiarias(0);
}

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
$corpo = $dados['desc_tar_diaria'];
$corpo = substr($corpo,0,75);
$estado = $dados['estado_tar_diaria'];


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


	<div class="row row-list" style="margin: 5vh auto;<?php if($estado==2){echo "border-bottom:4px solid black !important;";}?><?php if($urg==1){echo "border-bottom:4px solid red;";}?>">

		<a href = "listar_tarefa_diaria.php?id=<?php echo $dados['id_tar_diaria']; ?>">

			<div class="col-md-2"> <h5><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h5></div>

			<div class="col-md-2"> <h5><strong>Título</strong> <br><br><?php echo $dados['titulo_tar_diaria']; ?> </h5></div>

			<div class="col-md-4"> <h5><strong>Descrição</strong> <br><br><?php echo $corpo; ?> </h5></div>

			<div class="col-md-2"><h5><strong>Colaborador</strong> <br><br><img src="img/users/<?php echo $dados['img']; ?>" class="img-circle" width="35px"><br><?php echo $dados['nome_user']; ?></h5></div>

			<div class="col-md-2">
			    <h5><strong>Estado</strong> <br><br>
    			    <a <?php if($_SESSION['admin']==1 || isset($idusertar)){?> href = "estado_diaria.php?id=<?php echo $dados['id_tar_diaria']; ?>&state=<?php echo $estado ?>&link=<?php echo $link ?>"<?php } else{ ?> href="#"  <?php } ?>>
    			        <button style="font-size:.9em;" type="button" class="btn btn-primary"><?php echo $state ?></button>
    			    </a>
			    </h5>
			</div>

		</a>
	
	</div>


<?php } ?>


</div>


</body>
</html>