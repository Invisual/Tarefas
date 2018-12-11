<?php include('headers.php'); ?>

<title>INVISUAL</title>

<style>
body{
	font-family: 'Raleway', sans-serif;
}

.col-index-users{
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    min-height: 150px;
    color: #333;
	border-left:none !important;
	background-repeat: no-repeat !important;
    background-size: 50% !important;
	background-position: bottom right !important;
	margin-left:0;
	padding:12px;
}

.col-index-users:hover {
    box-shadow: 0 5px 9px rgba(0,0,0,0.26), 0 5px 9px rgba(0,0,0,0.29) !important;
    top: -3px;
    border-left: none !important;
}

.col-index-users .row, .col-index-users .col-md-12{
	height:100%;
}

.h3userindex{
	padding: 0;
    margin: 0;
    color: #5a5454;
    font-weight: 700;
    letter-spacing: .02em;
	font-size: 16px;
	position:unset;
}

.cargo-user{
	position: unset;
    margin: 0;
    font-weight: 600;
    letter-spacing: .03em;
    color: #b1aeae;
    font-size: 14px;
    margin-top: 5px;
}

.tarefas-user{
	margin: 0;
	position: absolute;
	bottom:0;
    color: #2196f3;
	font-weight: 600;
	font-size:12px;
	letter-spacing: .05em;
}


@media only screen and (min-width:991px){
	.flex-container{
	display:flex;
	justify-content:space-around;
	width:100%;
	margin:10px 0 30px 0;
	}

	.flex-item{
		width:13%;
	}
}

@media only screen and (max-width:991px){
	.col-index-users{
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    min-height: 150px;
    color: #333;
	border-left:none !important;
	background-repeat: no-repeat !important;
    background-size: contain !important;
	background-position: bottom right !important;
	margin-left:0;
	padding:12px;
	width:65%;
	margin:0 auto;
}
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




<!-- PARA UTILIZADORES NORMAIS -->

<?php if($_SESSION['admin']==0){ ?>


	<div class="container-fluid" style="position:relative; top:20vh;">

		<div class="row-fluid">
		    

			<div class="col-md-4">
				<a href="list_tarefas.php">
					<div class="col-spaced">
						<i class="fa fa-tasks icons-home" aria-hidden="true"></i>
						<h3>Tarefas</h3>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="list_tarefas_urg.php">
					<div class="col-spaced">
						<i class="fa fa-exclamation-circle  icons-home" aria-hidden="true"></i>
						<h3>Tarefas Urgentes</h3>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="list_my_tarefas.php">
					<div class="col-spaced">
						<i class="fa fa-thumb-tack icons-home" aria-hidden="true"></i>
						<h3>As Minhas Tarefas</h3>
					</div>
				</a>     
			</div>

		</div>


		<div class="row-fluid" style="position:relative; top:10vh;">

			<div class="col-md-4">
				<a href="insert_tarefa.php">
					<div class="col-spaced">
						<i class="fa fa-plus icons-home" aria-hidden="true"></i>
						<h3>Nova Tarefa</h3>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="insert_cliente.php">
					<div class="col-spaced">
						<i class="fa fa-plus-circle  icons-home" aria-hidden="true"></i>
						<h3>Novo Cliente</h3>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="list_clientes.php">
					<div class="col-spaced">
						<i class="fa fa-users icons-home" aria-hidden="true"></i>
						<h3>Clientes</h3>
					</div>
				</a>
			</div>

		</div>
		


	</div>


	<?php } ?>
<!-- PARA UTILIZADORES NORMAIS -->













<!-- PARA UTILIZADORES COM PRIVILÉGIOS -->

<?php if($_SESSION['admin']==1){ ?>








<div class="container-fluid containerindex" style="position:relative; top:10vh; padding-bottom:5vh;">

<div class="flex-container">


		<div class="flex-item">

				<?php 
				$listUsersCargo = $count->listUsersCargo(1);
				while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

					$nome = $dados['nome_user'];
					$img = $dados['img'];
					$id = $dados['id_user'];

					$CargoUser = $count->CargoUtilizador($id);
					$TarefasPorUser = $count->TarefasPorUtilizador($id);

					while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
						$cargo = $dados['nome_cargo_user'];
					}



					?>

					<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
					<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
						<div class="row">
							<div class="col-md-12">
								<h3 class="h3userindex"><?php echo $nome; ?></h3>
								<h4 class="cargo-user"><?php echo $cargo ?></h4>
								<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
							</div>
						</div>
					</div>
					</a>

				<?php } ?>

		</div>


		<div class="flex-item">

			<?php 
			$listUsersCargo = $count->listUsersCargo(2);
			while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$CargoUser = $count->CargoUtilizador($id);
				$TarefasPorUser = $count->TarefasPorUtilizador($id);

				while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
					$cargo = $dados['nome_cargo_user'];
				}



				?>

				<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
				<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
					<div class="row">
						<div class="col-md-12">
							<h3 class="h3userindex"><?php echo $nome; ?></h3>
							<h4 class="cargo-user"><?php echo $cargo ?></h4>
							<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
						</div>
					</div>
				</div>
				</a>

			<?php } ?>

		</div>


		<div class="flex-item">

			<?php 
			$listUsersCargo = $count->listUsersCargo(3);
			while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$CargoUser = $count->CargoUtilizador($id);
				$TarefasPorUser = $count->TarefasPorUtilizador($id);

				while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
					$cargo = $dados['nome_cargo_user'];
				}



				?>

				<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
				<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
					<div class="row">
						<div class="col-md-12">
							<h3 class="h3userindex"><?php echo $nome; ?></h3>
							<h4 class="cargo-user"><?php echo $cargo ?></h4>
							<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
						</div>
					</div>
				</div>
				</a>

			<?php } ?>

		</div>
				
		

		<div class="flex-item">

			<?php 
			$listUsersCargo = $count->listUsersCargo(4);
			while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$CargoUser = $count->CargoUtilizador($id);
				$TarefasPorUser = $count->TarefasPorUtilizador($id);

				while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
					$cargo = $dados['nome_cargo_user'];
				}



				?>

				<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
				<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
					<div class="row">
						<div class="col-md-12">
							<h3 class="h3userindex"><?php echo $nome; ?></h3>
							<h4 class="cargo-user"><?php echo $cargo ?></h4>
							<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
						</div>
					</div>
				</div>
				</a>

			<?php } ?>

		</div>


		<div class="flex-item">

			<?php 
			$listUsersCargo = $count->listUsersCargo(5);
			while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$CargoUser = $count->CargoUtilizador($id);
				$TarefasPorUser = $count->TarefasPorUtilizador($id);

				while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
					$cargo = $dados['nome_cargo_user'];
				}



				?>

				<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
				<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
					<div class="row">
						<div class="col-md-12">
							<h3 class="h3userindex"><?php echo $nome; ?></h3>
							<h4 class="cargo-user"><?php echo $cargo ?></h4>
							<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
						</div>
					</div>
				</div>
				</a>

			<?php } ?>

		</div>


		<div class="flex-item">

				<?php 
			$listUsersCargo = $count->listUsersCargo(6);
			while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$CargoUser = $count->CargoUtilizador($id);
				$TarefasPorUser = $count->TarefasPorUtilizador($id);

				while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
					$cargo = $dados['nome_cargo_user'];
				}



				?>

				<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
				<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
					<div class="row">
						<div class="col-md-12">
							<h3 class="h3userindex"><?php echo $nome; ?></h3>
							<h4 class="cargo-user"><?php echo $cargo ?></h4>
							<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
						</div>
					</div>
				</div>
				</a>

			<?php } ?>

		</div>



		<div class="flex-item">

			<?php 
			$listUsersCargo = $count->listUsersCargo(7);
			while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$CargoUser = $count->CargoUtilizador($id);
				$TarefasPorUser = $count->TarefasPorUtilizador($id);

				while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
					$cargo = $dados['nome_cargo_user'];
				}



				?>

				<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
				<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
					<div class="row">
						<div class="col-md-12">
							<h3 class="h3userindex"><?php echo $nome; ?></h3>
							<h4 class="cargo-user"><?php echo $cargo ?></h4>
							<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
						</div>
					</div>
				</div>
				</a>

			<?php } ?>

			<?php 
			$listUsersCargo = $count->listUsersCargo(8);
			while($dados= $listUsersCargo->fetch(PDO::FETCH_ASSOC)){

				$nome = $dados['nome_user'];
				$img = $dados['img'];
				$id = $dados['id_user'];

				$CargoUser = $count->CargoUtilizador($id);
				$TarefasPorUser = $count->TarefasPorUtilizador($id);

				while($cargos= $CargoUser->fetch(PDO::FETCH_ASSOC)){
					$cargo = $dados['nome_cargo_user'];
				}



				?>

				<a href="list_tarefas_user.php?iduser=<?php echo $id; ?>">		
				<div class="col-spaced col-index-users" style="margin-top:30px;border-left: 8px solid #487bb8; background: #fff url('img/users/<?php echo $img; ?>');">
					<div class="row">
						<div class="col-md-12">
							<h3 class="h3userindex"><?php echo $nome; ?></h3>
							<h4 class="cargo-user"><?php echo $cargo ?></h4>
							<h5 class="tarefas-user"><?php echo $TarefasPorUser ?> Tarefas</h5>
						</div>
					</div>
				</div>
				</a>

			<?php } ?>

		</div>


</div>



</div>


<?php } ?>
<!-- PARA UTILIZADORES COM PRIVILÉGIOS -->

</body>

</html>