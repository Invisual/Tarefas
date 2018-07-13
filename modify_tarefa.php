<?php include('headers.php'); ?>

<title>BILA POINT - Editar Sítio</title>


<style>
h3{
	color:white;
}

.formrow{
  height:90px !important;
}

</style>

<html>


<?php
;
session_start();
$id=$_GET['id'];

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


if($_SESSION['logged_in']!=1){
	header('location:login.php');
}



$obj = new classes_DbManager ();
$dado = $obj-> listSitio($id);

while($dados= $dado->fetch_array(MYSQLI_ASSOC)){

$name = $dados['nome'];
$nome= $dados['img'];
$desc = $dados['descricao'];
$morada = $dados['morada'];
$cordx = $dados['coordenada_x'];
$cordy = $dados['coordenada_x'];
$face = $dados['facebook'];
$telef = $dados['telefone'];
$mail = $dados['mail'];
$website = $dados['website'];


}


?>

<?php include('navbar.php'); ?>
<body>

<section id="main">
<?php include('sidebar.php');?>

<section class="content">
<div class="container-fluid">

<h3 style="color:#333; margin-top:15vh; margin-left:7vw;">Modificar <?php echo $name; ?></h1>


<form name="jobs" method="POST" action="" enctype="multipart/form-data">
<br>

<div class="row formrow">

<div class="col-md-5">
<h5>Nome do Sítio</h5>
<input class="form-control" type="text" name="nome" id="nome" value="<?php echo $name; ?>" >
</div>


<div class="col-md-5">
<h5>Website</h5>
<input type="text" class="form-control" name="website" id="website" value="<?php echo $website; ?>">
</div>

</div>


<div class="row formrow">

<div class="col-md-5">
<h5>Email:</h5>
<input class="form-control" type="text" name="email" id="email" value="<?php echo $mail; ?>" >
</div>


<div class="col-md-5">
<h5>Morada</h5>
<input class="form-control" type="text" name="morada" id="morada" value="<?php echo $morada; ?>" >
</div>

</div>



<div class="row formrow">

<div class="col-md-5">
<h5>Coordenada X</h5>
<input type="text" class="form-control" name="cordx" id="cordx" value="<?php echo $cordx; ?>">
</div>

<div class="col-md-5">
<h5>Coordenada y</h5>
<input type="text" class="form-control" name="cordy" id="cordy" value="<?php echo $cordy; ?>" >
</div>

</div>


<div class="row formrow">

<div class="col-md-5">
<h5>Telefone</h5>
<input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo $telef; ?>">
</div>

<div class="col-md-5">
<h5>Facebook</h5>
<input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo $face; ?>">
</div>

</div>

<div class="row formrow">

<div class="col-md-10">
<h5>Website</h5>
<input type="text" class="form-control" name="website" id="website" value="<?php echo $website; ?>">
</div>

</div>

<div class="row formrow">

<div class="col-md-10">
<h5>Descrição do Sítio</h5>
<textarea class="form-control" style="height:80px !important;" name="descricao" rows="4" style="width:100%"><?php echo $desc; ?> </textarea>
</div>

</div>


<div class="row formrow" style="margin-top:40px;height: 260px !important;">

<div class="col-md-10">
<h5>Imagem</h5>
<img src="img/<?php echo $nome; ?>" width="200px" class="img-responsive" style="border-radius:2px;" />
<br>
<input type="file" class="form-control" name="arquivo" />
</div>

</div>



<div class="row formrow" >

<div class="col-md-10">
<input type="submit" id="botaosubmit" class="form-control" name="submit" id="submit" style="background-color:#ca6358; color:#f1f1f1;">
</div>

</div>

</form>

<br>
<br>



</div>

</section>

<?php
if(!empty($_POST['submit'])){
	
	$name = $_POST['nome'];
	$img = $_POST['img'];
	$desc = $_POST['descricao'];
	$morada = $_POST['morada'];
	$cordx = $_POST['cordx'];
	$cordy = $_POST['cordy'];
	$face = $_POST['facebook'];
	$telef = $_POST['telefone'];
	$mail = $_POST['email'];
	$website = $_POST['website'];
	

	
	
		
	
	try{



		if (!empty($_FILES['arquivo']['name'])){

			$arqName = $_FILES['arquivo']['name'];
			$arqTemp = $_FILES['arquivo']['tmp_name'];
			$pasta = 'img/';
			

		//extensao do arquivo enviado

			$extensaoTemp = explode('.',$arqName);

			$extensao = strtolower(end($extensaoTemp));

		//nome do arquivo TimesTamp

			$nome = time(). '.' . $extensao;

			$upload = move_uploaded_file($arqTemp, $pasta . $nome);
			
			if ($upload === true)

			{



				$ficheiro = $pasta.$nome; 

				$resizeObj = new classes_ResizeClass($ficheiro); 

				$resizeObj -> resizeImage(1600, 1200, 'auto');

				$resizeObj -> saveImage("img/$nome", 100);
				
			}

		}
	


		$log = new classes_UserManager($myControlPanel);
		$insert = $log->updateSitio($id, $name, $nome, $desc, $morada, $cordx, $cordy, $face, $telef, $mail, $website);
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}

}

?>

</section>
</body>
</html>