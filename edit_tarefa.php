<?php include('headers.php');?>
<link href="css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.0/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.0/js/froala_editor.pkgd.min.js"></script>
<title>INVISUAL - Editar Tarefa</title>


<style>
body{
	font-family: 'Raleway', sans-serif;
}

.icons-header{
	color:#2196f3 !important;
}

.row-form-holder{
	background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding-bottom: 20px;
    min-height: 225px;
    position: relative;
    padding: 35px 45px 45px 45px;
    color: #333;
    width: 75%;
    overflow: hidden;
    margin: 35px auto 35px auto;
}

.row-form-holder h2{
	color: #5a5454;
    font-weight: 700;
    letter-spacing: .03em;
	font-size:18px;
	line-height:20px;
	margin:0;
	margin-bottom: 25px;
}

.rowinsert {
    width: 100%;
    margin: auto;
}

.form-editar-tarefa input[type="text"], .form-editar-tarefa select, .form-editar-tarefa textarea{
	border-radius: 14px;
    background-color: #f7f7f7;
    border: none;
	height:40px;
	width:100%;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
	margin-bottom: 15px;
    margin-top: 10px;
	text-indent:15px;
}


.row-checkboxes input[type=checkbox] {
    visibility: hidden;
	
}

.checkboxOne {
    width: 40px;
    height: 6px;
    background: #555;
    margin: 20px auto 0 auto;
    position: relative;
    border-radius: 3px;
}

/**
 * Create the slider from the label
 */
 .checkboxOne label {
	display: block;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    transition: all .5s ease;
    cursor: pointer;
    position: absolute;
    top: -4px;
    left: -1px;
    background: #ccc;
}

/**
 * Move the slider in the correct position if the checkbox is clicked
 */
 .checkboxOne input[type=checkbox]:checked + label {
    left: 27px;
	background:#5ab963;
}

textarea{
	padding-top: 12px;
}

.row-users h5, .checkbox-span{
	font-weight: 600;
    letter-spacing: .05em;
    color: #b1aeae;
	padding-bottom:10px;
}

.col-center{
	text-align: center;
}

.add-on{
	background-color: transparent !important;
    border: none !important;
    margin-bottom: 15px;
    margin-top: 10px;
}

.submit-btn-holder{
	text-align:center;
	padding-bottom:50px;
}

.btn-submit-form{
	background-color: #2196f3 !important;;
    border-radius: 14px !important;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    color: #fff !important;
    width: 200px !important;
	border:none !important;
	padding: 10px;
    font-weight: 600;
}


</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

$today = date('Y-m-d');
$tomorrow = new DateTime('tomorrow');




$idtarefa = $_GET['id'];

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
	
	$titulo = $_POST['titulo'];
	$descricao = $_POST['descricao'];
	$cliente = $_POST['cliente'];
	$dataini = '0000-00-00';
	$datafim = $_POST['datafim'];
	$urgente = 0;
	$faturacao = $_POST['faturacao'];
	$tipotarefa = $_POST['tipo_tarefa'];

	if($_POST['tipo_tarefa'] == 1){ $tarefadiaria = 1; }
	else{ $tarefadiaria = 0;}


	if(!empty($_POST['intervenientes']))$intervenientes = $_POST['intervenientes'];
	else{
		$intervenientes = [];
	}

	
	try{		
		$log = new classes_UserManager($myControlPanel);
		$update = $log->updateTarefa($titulo, $descricao, $cliente, $dataini, $datafim, $urgente, $intervenientes, $idtarefa, $tarefadiaria, $faturacao, $tipotarefa);
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}




$obj = new classes_DbManager ();
$dado = $obj-> listTarefa($idtarefa);

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
    $titulo = $dados['titulo'];
    $desc = $dados['descricao'];
    $dataini = $dados['data_ini'];
	$datafim = $dados['data_fim'];
    $cliente = $dados['id_cliente'];
    $nomeuser = $dados['nome_user'];
	$prioridade = $dados['valor_prioridade'];
	$urgente = $dados['urgente'];
	$faturada = $dados['faturada'];
	$avenca = $dados['avenca'];
	$tipo = $dados['tipo_tarefa'];
}





?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header">Editar Tarefa - <?php echo $titulo ?> </h1>


<form name="tarefas" class="form-editar-tarefa" method="POST" enctype="multipart/form-data" action="">
<br>

<div class="row-form-holder form-titulo-cliente-desc">

	<h2>Título, Descrição e Cliente da nova Tarefa.</h2>

	<div class="row rowinsert">
		<div class="col-md-6">
			<input placeholder="Título da Tarefa" type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>" required>
		</div>
		<div class="col-md-6">
		<select name="cliente" required>
		<option value="" disabled selected>Cliente</option>
		<?php
		$myDb = new classes_DbManager;
		$query = $myDb->_myDb->prepare("Select * from clientes order by nome");
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			{
			echo "<option ". ($cliente == $row['id_cliente'] ? 'selected = "selected"':'') ." value=".$row['id_cliente'].">".$row['nome']."</option>";
			}
		?>
		</select>
		</div>
	</div>

	<div class="row rowinsert">
		<div class="col-md-12">
			<textarea placeholder="Descrição da Tarefa" name="descricao" style="height:100px !important;" rows="4"><?php echo $desc; ?></textarea>
		</div>
	</div>

</div>

<div class="row-form-holder form-titulo-cliente-desc row-checkboxes">

	<h2>Data, Tipo e Faturação de Tarefa.</h2>
	
	<div class="row rowinsert">

		<div class="col-md-4 col-center">
			

				<div id="datepickersala1" class="input-append date">
				<input type="text" name="datafim" id="datafim" value="<?php echo $datafim?>" placeholder="Data Limite">></input>
				<span class="add-on">
					<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				</span>
				</div>
				<script type="text/javascript"
				src="js/bootstrap-datetimepicker.min.js">
				</script>
				<script type="text/javascript"
				src="js/bootstrap-datetimepicker.pt-BR.js">
				</script>
				<script type="text/javascript">
				$('#datepickersala1').datetimepicker({
					format: 'yyyy/MM/dd',
					language: 'pt-BR'
				});
				</script>
			
		</div>


		<div class="col-md-4 col-center">

				<select name="tipo_tarefa" required>
					<option value="" disabled>Tipo de Tarefa</option>
					<option value="0" <?php if($tipo == 0){ echo 'selected'; }?>>Tarefa Normal</option>
					<option value="1" <?php if($tipo == 1){ echo 'selected'; }?>>Tarefa Diária</option>
					<option value="2" <?php if($tipo == 2){ echo 'selected'; }?>>Tarefa Externa</option>
			</select>
		
		</div>
		
		
		<div class="col-md-4 col-center">

			<select name="faturacao" required>
				<option value="" disabled>Tipo de Faturação</option>
				<option value="0" <?php if($faturada == 0){ echo 'selected'; }?>>Para Faturar</option>
				<option value="2" <?php if($faturada == 2){ echo 'selected'; }?>>Em Avença</option>
				<option value="3" <?php if($faturada == 3){ echo 'selected'; }?>>Em Análise</option>
				<option value="4" <?php if($faturada == 4){ echo 'selected'; }?>>Gratuita</option>
			</select>

		
		</div>


	</div>


</div>

<div class="row-form-holder form-titulo-cliente-desc">

	<h2>Elementos para trabalharem nesta Tarefa.</h2>
	

	<div class="row rowinsert row-users">
	<div class="col-md-3">
	<h5>CEO & Financial</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 1 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>

	<div class="col-md-3">
	<h5>Design</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 2 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>


	<div class="col-md-3">
	<h5>Web Design</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 3 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>


	<div class="col-md-3">
	<h5>Account</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 4 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>

</div>


<div class="row rowinsert row-users" style="margin-top:5vh !important;">
	<div class="col-md-3">
	<h5>Press & Copy</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 5 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>

	<div class="col-md-3">
	<h5>Digital Marketing</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 6 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>


	<div class="col-md-3">
	<h5>Multimedia</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 7 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>


	<div class="col-md-3">
	<h5>Production</h5>
		<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where cargo = 8 and inativo != '1' order by nome_user asc");
				$query->execute();
				$interv = $myDb->_myDb->prepare("Select user_interv_id from intervenientes_tarefa where tarefa_interv_id = '$idtarefa'");
				$interv->execute();
				$usersinterv = $interv->fetchAll(PDO::FETCH_COLUMN);
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{ ?>
					<img src="img/users/<?php echo $row['img'] ?>" class="img-circle" width="35px" >
					&nbsp;<?php echo $row['nome_user'] ?>&nbsp;
					<input type="checkbox" name="intervenientes[]" <?php if( in_array($row['id_user'],$usersinterv)){echo "checked";} ?> value="<?php echo $row['id_user'];?>">
					<br><br>
		<?php } ?>
	</div>

</div>



</div>


	<div class="submit-btn-holder">
		<input type="submit" class="form-control btn btn-primary btn-submit-form" value="Editar" onclick="check();" name="submit" id="submit">
	</div>

</form>


</div>

<script>
  $(function() {
    $('textarea').froalaEditor()
  });
</script>
</body>

</html>