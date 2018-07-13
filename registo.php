<?php include('headers.php'); ?>

<title>INVISUAL - Adicionar Projeto</title>



<style>
.btn-primary{
	background-color:#2f323a !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#fff !important;
	border:none !important;
}

.btn-primary:hover{
	background-color:#5093e1 !important;
	border:none !important;
}

</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']!=1){
	header('location:index.php');
}

if($_SESSION['admin']!=1){
	header('location:index.php');
}


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


if(!empty($_POST)){
	
	$username = $_POST['username'];
	$nome = $_POST['nome'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$img = $_POST['img'];

	
	try{		
		$log = new classes_UserManager($myControlPanel);

		if( $password == $repassword ){
			$password = md5($password);
			$insert = $log->insertUser($username, $nome, $password, $img);
		}
		else{
			echo "
				<script type='text/javascript'>
					window.alert('As duas password não coincidem!');
					location.reload();
				</script>
			";
		}
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}





?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header">Adicionar User</h1>

<form name="registo" method="POST" enctype="multipart/form-data" action="">
<br>

<div class="row rowinsert">
	<div class="col-md-12">
		<input class="form-control" placeholder="Username" type="text" name="username" id="titulo" required>
	</div>
</div>
<br>
<br>
<div class="row rowinsert">
	<div class="col-md-12">
		<input class="form-control" placeholder="Primeiro e Último Nome" type="text" name="nome" id="titulo" required>
	</div>
</div>
<br>
<br>
<div class="row rowinsert">
	<div class="col-md-12">
		<input class="form-control" placeholder="Imagem" type="text" name="img" id="titulo" required>
	</div>
</div>
<br>
<br>
<div class="row rowinsert">

	<div class="col-md-6">
		<input required class="form-control" type="password" placeholder="Password" name="password" id="dataini" >
	</div>

	<div class="col-md-6">
		<input required class="form-control" type="password" placeholder="Digite a Password novamente" name="repassword" id="datafim" >
	</div>

</div>
<br>
<br>
<div class="row rowinsert" style="margin-top:5vh;">
	<div class="col-md-12">
		<input type="submit" class="form-control btn btn-primary" value="Adicionar" onclick="check();" name="submit" id="submit">
	</div>
</div>

</form>



</div>

</body>

</html>