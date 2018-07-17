<?php include('headers.php'); ?>

<title>INVISUAL</title>

<style>
body{
	font-family: 'Raleway', sans-serif;
}

.div-user-horas{
	background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding-bottom: 20px;
    min-height: 225px;
	position:relative;
    padding: 20px 30px 20px 30px;
    color: #333;
    width: 75%;
    margin: 0 auto;
	margin-top:40px;
    float: none;
	overflow:hidden;
}

.div-user-horas h1{
	padding:0;
	margin:0;
	margin-bottom:30px;
}

.div-user-horas h1 span{
	color: #5a5454;
    font-weight: 700;
    letter-spacing: .02em;
    font-size: 20px;
    margin-left: 10px;
}

.img-user-horas{
	width: 35px;
    display: inline-block;
}

.registo-hora-single{
	margin-left:40px;
	font-size: 16px;
	font-weight: 500;
	color:#b1aeae;
}

.dia{
	font-weight: 300;
	margin-right: 15px;
}

.horas{
	margin-right: 15px;
}

.tarefa strong{
	margin-left: 15px;
}

</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']==0){
	header('location:login.php');
}

$iduser = $_SESSION['id'];

if (empty($myControlPanel)) {

	try {

	$myControlPanel = new classes_ControlPanel();

	$myControlPanel->setMyDb(classes_DbManager::ob());

	$myDbManager = $myControlPanel->getMyDb();

	$count = classes_DbManager::ob();

	$countNotificacoes= $count->contarNotificacoes($iduser);

	$getNotificacoes= $count->getNotificacoes($iduser); 
	
	$countNotificacoesMensagens= $count->contarNotificacoesMensagens($iduser);

	$getNotificacoesMensagens= $count->getNotificacoesMensagens($iduser); 

	$listUsers = $count->listAllUsers();



	}


	catch (Exception $e) {

		echo $e->getMessage();
		die();
	}


}



?>
<?php include('navbar.php'); ?>

<body>


<?php if($_SESSION['admin']==1){ ?>




<div class="container-fluid" style="position:relative; top:10vh; padding-bottom:5vh;">

		    
			<?php while($dados= $listUsers->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$horasUser = $count->HorasUtilizador($id);

			?>
				
				<div class="row">

						<div class="col-md-12 div-user-horas">

							<h1><img src="img/users/<?php echo $img; ?>" class="img-responsive img-user-horas img-circle"><span><?php echo $nome ?></h1></span>

							<?php
								while($horas = $horasUser->fetch(PDO::FETCH_ASSOC)){
									$horaini = $horas['hora_inicio'];
									$horafim = $horas['hora_fim'];
									$dia = $horas['dia'];
									$titulo = $horas['titulo'];
									$cliente = $horas['nome'];
							?>

									<p class="registo-hora-single">
										<span class="dia"><?php echo $dia ?></span>
										<span class="horas"><?php echo $horaini ?> - <?php echo $horafim ?></span>
										<span class="tarefa"><?php echo $titulo ?> <strong><?php echo $cliente ?></strong></span>
										<a href="editarhorasgeral.php?idhora=<?php echo $horas['id_hora'] ?>&idtarefa=<?php echo $horas['tarefa_id'] ?>">
											<i class="fa fa-wrench" style="margin-left:20px;"></i>
										</a>
										<a href="deletehorageral.php?idhora=<?php echo $horas['id_hora'] ?>&idtarefa=<?php echo $horas['tarefa_id'] ?>" onclick="return checkDeleteHora();">
											<i class="fa fa-trash" style="margin-left:20px;"></i>
										</a>
									</p>


							<?php } ?>

						</div>

				</div>

			<?php }?>





</div>


<?php } else{?>
<h1 class="text-center">XÔ DAQUI!!</h1>
<?php } ?>

<script>
function checkDeleteHora(){
    return confirm('Tem a certeza que quer eliminar este registo de Horas?');
}
</script>


</body>

</html>