<?php include('headers.php'); ?>
<link href="css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">

<title>INVISUAL - Editar Custos de Tarefa</title>

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

.form-inserir-tarefa input[type="text"], .form-inserir-tarefa input[type="number"], .form-inserir-tarefa select, .form-inserir-tarefa textarea{
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

.btn-more-inputs{
	position: absolute;
    bottom: 10px;
    left: 20px;
	cursor:pointer;
}

.btn-more-inputs i{
	color:#2196f3;
	font-size:22px;
}

.delete-row i{
	font-size: 16px;
    color: #eb4033;
    position: relative;
    top: 40px;
	cursor:pointer;
}

.rowcustostarefa{
	margin-top:15px;
}

.rowcustostarefa:first-child .delete-row i{
	display:none;
}

label{
	margin-bottom: 0;
    font-weight: 600;
    color: #929292;
    letter-spacing: .02em;
	font-size:13px;
}
</style>


<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']!=1 || $_SESSION['admin']==0){
	header('location:index.php');
}

$today = date('Y-m-d');
$tomorrow = new DateTime('tomorrow');


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

$idtarefa = $_GET['id'];


if(!empty($_POST)){
	
	$servicos = $_POST['servicos'];
	$custosfornecedor = $_POST['custosfornecedor'];
	$custosvenda = $_POST['custosvenda'];

	try{		
		$log = new classes_UserManager($myControlPanel);
		$delete = $log->deleteCustosTarefa($idtarefa);
		$insert = $log->insertCustosTarefa($idtarefa, $servicos, $custosfornecedor, $custosvenda);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}


$obj = new classes_DbManager ();
$dado = $obj-> listarRegistosCustosTarefa($idtarefa);

?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp;Adicionar Custo de Tarefa</h1>

<form name="tarefas" class="form-inserir-tarefa" method="POST" enctype="multipart/form-data" action="">
<br>

<div class="row-form-holder form-titulo-cliente-desc">

	<h2>Custos Fornecedores e Valores de Venda da Tarefa</h2>

	<div class="inputs-rows">

		<?php
		while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
			$servico = $dados['servico'];
			$custof = $dados['custo_fornecedor'];
			$custov = $dados['custo_venda'];
		?>

			<div class="row rowcustostarefa">

				<div class="col-md-5">
					<label for="servicosinput">Produto/Serviço</label>
					<textarea id="servicosinput" name="servicos[]"><?php echo $servico?></textarea>
				</div>


				<div class="col-md-3">
					<label for="fornecedorinput">Custo Fornecedor</label>
					<input type="number" min=0 step=0.01 value="<?php echo $custof?>" id="fornecedorinput" name="custosfornecedor[]" />
				</div>


				<div class="col-md-3">
					<label for="vendainput">Custo de Venda</label>
					<input type="number" min=0 step=0.01 value="<?php echo $custov?>" id="vendainput" name="custosvenda[]" />
				</div>

				<div class="col-md-1 col-center delete-row"><i class="fa fa-trash"></i></div>

			</div>

		<?php } ?>

	</div>

	<div class="btn-more-inputs"><i class="fa fa-plus" id="more-inputs"></i></div>

</div>


<div class="submit-btn-holder">
	<input type="submit" class="form-control btn btn-primary btn-submit-form" value="Editar" onclick="check();" name="submit" id="submit">
</div>

</form>



</div>

<script>
	$('#more-inputs').on('click', function(){
		var newInput = $('.rowcustostarefa:first').clone();
		newInput.find('input').val('');
		newInput.appendTo('.inputs-rows');
	})

	$('.inputs-rows').on('click', '.delete-row:not(:first)', function(){
		$(this).parent('.rowcustostarefa').remove();
	})
</script>
</body>


</html>