<?php include('headers.php'); ?>

<title>INVISUAL - Tarefa Diária</title>


<style>
	.page-header{
		    margin: 40px 0 -6px !important;
			border:none !important;
	}
	.btn-primary{
	background-color: #5093e1 !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#fff !important;
	border:none !important;
    position:relative;
}

.btn-primary:hover{
    background-color: #5093e1 !important;
	box-shadow: 0 8px 3px rgba(0,0,0,.1) !important;
    top:-1px;
}

h5{
	font-size:1.1em;
	position:relative;
	left:4vw;	
}
</style>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer eliminar esta Tarefa Diária? Esta ação é irreversível!');
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

// IR BUSCAR DADOS PARA LISTAR A TAREFA

$idtarefa = $_GET['id'];
$idnotificacao=$_GET['not'];
$iduser = $_SESSION['id'];

$obj = new classes_DbManager ();
$dado = $obj-> listTarefaDiaria($idtarefa);
//$notificacaoVista = $obj -> notificacaoVista($idnotificacao, $iduser);


while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
    $titulo = $dados['titulo_tar_diaria'];
    $desc = $dados['desc_tar_diaria'];
    $cliente = $dados['nome'];
    $idusertar = $dados['nome_user'];
    $nomeuser = $dados['nome_user'];
	$imguser = $dados['img'];
	$estado = $dados['estado_tar_diaria'];
}

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

?>


<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

	<div class="row rowtarefa">

		<div class="col-md-12">

		<?php if($_SESSION['admin']==1 || $iduser == $idusertar ){ ?>
			<div class="botoes">
				<a href = "edit_tarefa_diaria.php?id=<?php echo $idtarefa ?>"><i class="fa fa-wrench" aria-hidden="true"></i></a>
				<a href = "delete_tarefa_diaria.php?id=<?php echo $idtarefa ?>" onclick="return checkDelete()"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
			</div>
		<?php } ?>


			<h3 class="page-header"><i class="fa fa-thumb-tack icons-header" title="Projetos" aria-hidden="true"></i> &nbsp;Tarefa Diária- <strong><?php echo $titulo ?></strong></h3>
			<h4 style="font-size:1.3em;">Cliente - <strong><?php echo $cliente; ?></strong></h4>
			<h5>Estado - <strong><?php echo $state?></strong></h5>
			<p><?php echo $desc ?></p>
			

			<div class="users-tarefa">
						<img src="img/users/<?php echo $imguser; ?>" class="img-circle img-user-tarefa" width="30px" title="<?php echo $nomeuser; ?>">
			</div>

		</div>

	</div>



</div>

</body>
</html>