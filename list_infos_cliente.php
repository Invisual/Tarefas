<?php 
session_start();
if($_SESSION['logged_in']==0){
	header('location:index.php');
}
include('headers.php');
date_default_timezone_set('Europe/Lisbon');
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
$x = 0;
?>

<title>INVISUAL - Tarefas</title>


<style>

body{
	font-family: 'Raleway', sans-serif;
}


.btn-primary{
	background-color: #2196f3 !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#fff !important;
	border:none !important;
    position:relative;
}

h5{
	font-size:1.1em;
	position:relative;
	left:4vw;	
}

.nodisplay{
	display:none;
}

.botoes-tarefa{
	text-align:right;
	padding-bottom: 20px;
}

.row-info-cliente{
	margin-top:40px;
	background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding-bottom: 20px;
    min-height: 185px;
    position: relative;
    padding: 20px 10px 10px 22px;
	color: #333;
	width:95%;
	margin:0 auto;
	margin-bottom:75px;
}

.row-info-cliente .row{
	margin: 50px 0 50px 0;
}

h4, h5{
	position:unset;
}

.titulo-info{
	color: #5a5454;
    letter-spacing: .03em;
    margin-top: 20px;
    font-weight: 600;
}

.titulo-info strong{
	color: #2196f3;
}

.row-info-cliente h5{
	color: #5a5454;
    font-weight: 700;
    letter-spacing: .02em;
}

.btn-hora-fim{
	background-color:#de0000 !important;
}


.botoes-tarefa i, .botoes-tarefa span, .botoes-tarefa-mobile i, .botoes-tarefa-mobile span{
	font-size:22px;
	padding-left: 15px;
	color:#2196f3;
}

#conteudo-obs{
	padding-left: 10px;
    color: #797676;
}

.row-info-cliente p{
	margin-left: 6px;
}

.icons{
	position:absolute;
	right:20px;
	top:20px;
}

.icons i{
	font-size:20px;
}

.print{
    display:none;
}

@media print { 
.row-info-cliente{
    display:none !important;
}
.print{
    display:block !important;
}
.container-fluid{
    top:0 !important;
}
h4{
    font-size:14px !important;
}
h5{
    font-size:12px !important;
}
p{
    font-size:10px !important;
}
}

</style>


<?php
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


// IR BUSCAR DADOS PARA LISTAR INFO DO CLIENTE

$idcliente = $_GET['cliente'];

$obj = new classes_DbManager ();
$dado = $obj-> listInfoCliente($idcliente);

if($dado->rowCount() == 0){
	$vazio = 1;
}

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
	$idinfo = $dados['id_info'];
    $nomeCliente = $dados['nome'];
    $linkCpanel = $dados['link_cpanel'];
    $userCpanel = $dados['username_cpanel'];
	$passCpanel = $dados['password_cpanel'];
    $nicDns = $dados['nichandle_dns'];
    $passDns = $dados['password_dns'];
	$linkWp = $dados['link_wordpress'];
	$userWp = $dados['username_wordpress'];
	$passWp = $dados['password_wordpress'];
	$emails = $dados['emails'];
	$outros = $dados['outros'];
}

$splitemails = explode(",", $emails);
$splitoutros = explode(",", $outros);

if(!$linkCpanel){$linkCpanel='-';}
if(!$userCpanel){$userCpanel='-';}
if(!$passCpanel){$passCpanel='-';}
if(!$nicDns){$nicDns='-';}
if(!$passDns){$passDns='-';}
if(!$linkWp){$linkWp='-';}
if(!$userWp){$userWp='-';}
if(!$passWp){$passWp='-';}
if(!$emails){$emails='-';}

?>


<?php include('navbar.php'); ?>
<body class="pagina-tarefa">

<script>
var prompt = prompt("Introduzir Password");
var pass = '123', pag = 'infos';
$.ajax({
	type:'POST',
	url:'ajax/check_pw.php',
	dataType: "json",
	data:{pw: prompt, pagina: pag},
	success:function(data){
		if(!data){window.location.href = "index.php";}
	}
});
</script>


<div class="container-fluid" style="position:relative; top:12vh;">

	<?php 
	
	if($vazio == 1){
		echo "<h3 class='text-center'>Este Cliente ainda não tem um registo de infos. Crie um <a href='insert_info_cliente.php'>aqui</a>.</h1>";
	}
	else{
	?>

	<div class="row-info-cliente">

			<div class="icons"><a href = "edit_info_cliente.php?idinfo=<?php echo $idinfo ?>"><i class="fa fa-wrench" aria-hidden="true" title="Editar Tarefa"></i></a></div>
			
			<h4 class="titulo-info">Infos do Cliente - <strong><?php echo $nomeCliente ?></strong></h4>

			<div class="row row-cpanel">
				
				<div class="col-md-4">
					<h5>Link cPanel</h5>
					<br>
					<p><a href="<?php echo $linkCpanel ?>"><?php echo $linkCpanel ?></a></p>
				</div>

				<div class="col-md-4">
					<h5>Username cPanel</h5>
					<br>
					<p><?php echo $userCpanel ?></p>
				</div>

				<div class="col-md-4">
					<h5>Password cPanel</h5>
					<br>
					<p><?php echo $passCpanel ?></p>
				</div>

			
			</div>

			<hr>

			<div class="row row-dns">
				
				<div class="col-md-4">
					<h5>NicHandle DNS</h5>
					<br>
					<p><?php echo $nicDns ?></p>
				</div>

				<div class="col-md-4">
					<h5>Password DNS</h5>
					<br>
					<p><?php echo $passDns ?></p>
				</div>
			
			</div>

			<hr>

			<div class="row row-wp">
				
				<div class="col-md-4">
					<h5>Link WordPress</h5>
					<br>
					<p><a href="<?php echo $linkWp ?>"><?php echo $linkWp ?></a></p>
				</div>

				<div class="col-md-4">
					<h5>Username WordPress</h5>
					<br>
					<p><?php echo $userWp ?></p>
				</div>

				<div class="col-md-4">
					<h5>Password WordPress</h5>
					<br>
					<p><?php echo $passWp ?></p>
				</div>

			
			</div>

			<hr>

			<div class="row row-email">
				
				<div class="col-md-12">
					<h5>Emails</h5>
					<br>
					<?php foreach($splitemails as $email){
						echo '<p>'.$email.'</p>';
					} ?>
				</div>

			</div>
			
			<?php if($outros){ ?>

				<hr>
						
				<div class="row row-outros">
					
					<div class="col-md-12">
						<h5>Outros</h5>
						<br>
						<?php foreach($splitoutros as $outro){
						echo '<p>'.$outro.'</p>';
					} ?>
					</div>

				</div>

			<?php } ?>

	</div>

	<?php } ?>
	
	<div class="print">
	    
	    <h4>Infos do Cliente - <strong><?php echo $nomeCliente ?></strong></h4>
	    
	    <h5>Link cPanel</h5>
		<p><?php echo $linkCpanel ?></p>
	    <h5>Username cPanel</h5>
		<p><?php echo $userCpanel ?></p>
		<h5>Password cPanel</h5>
		<p><?php echo $passCpanel ?></p>
		
		 <hr>
		 
         <h5>NicHandle DNS</h5>
		<p><?php echo $nicDns ?></p>
        <h5>Password DNS</h5>
		<p><?php echo $passDns ?></p>
		
		 <hr>
        
        <h5>Link WordPress</h5>
		<p><?php echo $linkWp ?></p>
        <h5>Username WordPress</h5>
		<p><?php echo $userWp ?></p>
		<h5>Password WordPress</h5>
		<p><?php echo $passWp ?></p>
		
		 <hr>
  
        <h5>Emails</h5>
		<?php foreach($splitemails as $email){
			        echo '<p>'.$email.'</p>';
			    } ?>
		
		 <hr>
        
	    <h5>Outros</h5>
		<?php foreach($splitoutros as $outro){
				    echo '<p>'.$outro.'</p>';
				} ?>
	    
	    
	</div>

</div>




<script>
	function RefreshWindow()
{
         window.location.reload(true);
}
</script>

</body>
</html>