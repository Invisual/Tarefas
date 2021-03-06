<?php include('headers.php'); ?>
<link href="css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">

<title>INVISUAL - Adicionar Info Cliente</title>

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

.row-form-holder input[type="text"], select, .row-form-holder textarea{
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

.row-cliente{
	width: 75%;
    overflow: hidden;
    margin: 35px auto 35px auto;
}


</style>


<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']!=1){
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


if(!empty($_POST)){
	
	$cliente = $_POST['cliente'];
	$linkCpanel = $_POST['link_cpanel'];
	$loginCpanel = $_POST['login_cpanel'];
	$passCpanel = $_POST['password_cpanel'];
	$nicDns = $_POST['nichandle_dns'];
	$passDns = $_POST['password_dns'];
	$linkWp = $_POST['link_wp'];
	$userWp = $_POST['username_wp'];
	$passWp = $_POST['password_wp'];
	$emailsInfo = $_POST['emails_info'];
	$outros = $_POST['outros_info'];

	try{		
		$log = new classes_UserManager($myControlPanel);
		$insert = $log->insertInfoCliente($cliente, $linkCpanel, $loginCpanel, $passCpanel, $nicDns, $passDns, $linkWp, $userWp, $passWp, $emailsInfo, $outros);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}





?>

<?php include('navbar.php'); ?>
<body>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-info-circle icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp;Adicionar Info Cliente</h1>

<form name="tarefas" method="POST" enctype="multipart/form-data" action="">
<br>

<div class="row-cliente">

	<select name="cliente" required>
				<option value="" disabled selected>Cliente</option>
				<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from clientes order by nome");
				$query->execute();
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{
					echo "<option value=".$row['id_cliente'].">".$row['nome']."</option>";
					}
				?>
	</select>

</div>

<div class="row-form-holder form-titulo-cliente-desc">

	<h2>Dados cPanel</h2>

	<div class="row rowinsert">
		<div class="col-md-4">
			<input placeholder="Link cPanel" type="text" name="link_cpanel" >
		</div>
		
		<div class="col-md-4">
			<input placeholder="Username cPanel" type="text" name="login_cpanel" >
		</div>

		<div class="col-md-4">
			<input placeholder="Password cPanel" type="text" name="password_cpanel" >
		</div>
	</div>

</div>

<div class="row-form-holder form-titulo-cliente-desc row-checkboxes">

	<h2>Dados DNS</h2>
	
	<div class="row rowinsert">

		<div class="col-md-6">
			<input placeholder="NicHandle DNS" type="text" name="nichandle_dns" >
		</div>

		<div class="col-md-6">
			<input placeholder="Password DNS" type="text" name="password_dns" >
		</div>

	</div>


</div>

<div class="row-form-holder form-titulo-cliente-desc">

	<h2>Dados Wordpress</h2>

	<div class="row rowinsert">
		<div class="col-md-4">
			<input placeholder="Link WordPress" type="text" name="link_wp" >
		</div>
		
		<div class="col-md-4">
			<input placeholder="Username WordPress" type="text" name="username_wp" >
		</div>

		<div class="col-md-4">
			<input placeholder="Password WordPress" type="text" name="password_wp" >
		</div>
	</div>
	
</div>


<div class="row-form-holder form-titulo-cliente-desc">

	<h2>Dados Emails</h2>

	<div class="row rowinsert">
		<div class="col-md-12">
			<textarea placeholder="Emails (separar com ,)" name="emails_info" style="height:100px !important;" rows="4"></textarea>
		</div>
	</div>
	
</div>



<div class="row-form-holder form-titulo-cliente-desc">

<h2>Outros</h2>

<div class="row rowinsert">
	<div class="col-md-12">
		<textarea placeholder="Qualquer informação pertinente" name="outros_info" style="height:100px !important;" rows="4"></textarea>
	</div>
</div>

</div>




<div class="submit-btn-holder">
	<input type="submit" class="form-control btn btn-primary btn-submit-form" value="Adicionar" onclick="check();" name="submit" id="submit">
</div>

</form>



</div>


</body>


</html>