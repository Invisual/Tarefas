<?php include('headers.php'); ?>

<title>INVISUAL - Clientes</title>


<style>

body{
    font-family: 'Raleway', sans-serif;
}

tr:hover{
	color:black !important;
}

.counter-horas{
	background-color: #e2e2e2;
    height: 15px;
    width: 90%;
    margin: 0 auto;
    border-radius: 6px;
	position:Relative;
	overflow:hidden;
}

.barra-horas{
    height: 100%;
    border-radius: 6px;
	position: absolute;
    left: 0;
    top: 0;
}

.pesquisa-tarefas-ajax {
    margin-left: 10px;
    height: 40px !important;
    border-radius: 3px !important;
    border: 1px solid #cccc;
    margin-right: 5px;
    text-indent: 10px;
    margin-bottom: 15px;
}

.liente {
    background-color: #2196f3;
    border: none;
    border-radius: 2px;
    color: #fff;
    height: 40px;
    width: 40px;
    transition: all .5s ease;
}

.input-mes{
	padding-left:3vw;
	margin-top:35px;
}

.input-mes form, .input-mes h4{
	display:inline-block;
}

.selected-month{
	background: #2196f3;
    color: #fff;
    padding: 10px;
    border-radius: 4px;
    letter-spacing: .05em;
}

.local-nav{
	position:absolute;
	top:40px;
	right:40px;
}

.nodisplay{
	display:none;
}

.print-graf{
    margin-top:10px;
    text-align:right;
    padding-right:40px;
}

.graf-tarefas{
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding: 25px 0px;
    margin: 50px auto;
    width:95%;
}

.graf-tarefas text{
    font-family: 'Raleway', sans-serif;
}

h3 strong{
	color:#2196f3;
}

.row-list{
	background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding: 25px 0px 20px 0;
    margin: 50px auto;
    width: 95%;
}

.row-list h2{
	text-align: center;
    font-size: 13px;
    color: #797676;
    font-weight: 500;
}

.row-list h2 strong{
	color: #5a5454;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: .03em;
}

.local-nav a{
	color:#2196f3;
}

.anchor-bold{
	font-weight: 600;
    font-size: 1.2em;
}

a:hover, a:focus, a:visited{
	text-decoration:none !important;
}
</style>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Tem a certeza que quer eliminar este Cliente? Vai eliminar todas as Tarefas associadas a este cliente. Esta ação é irreversível!');
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


if(empty($_POST['pesquisa-avenca-mes'])){
	$mes = date("m");
}
else{
	$mes = $_POST['mes'];
}

	switch ($mes){
	
		case '01':
		$nomemes = 'Janeiro';
		break;
	
		case '02':
		$nomemes = 'Fevereiro';
		break;
	
		case '03':
		$nomemes = 'Março';
		break;
	
		case '04':
		$nomemes = 'Abril';
		break;
	
		case '05':
		$nomemes = 'Maio';
		break;
								
		case '06':
		$nomemes = 'Junho';
		break;
	
		case '07':
		$nomemes = 'Julho';
		break;
	
		case '08':
		$nomemes = 'Agosto';
		break;
	
		case '09':
		$nomemes = 'Setembro';
		break;
	
		case '10':
		$nomemes = 'Outubro';
		break;
	
		case '11':
		$nomemes = 'Novembro';
		break;
	
		case '12':
		$nomemes = 'Dezembro';
		break;
	}


?>


<?php include('navbar.php'); ?>
<body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

	function iniciarGrafs(){
		$.ajax({
					type: "GET",
					url: "./ajax/listagem_clientes_avenca.php",
					success: function(data){
						data.clientes.forEach(function(cliente){
							var container = document.getElementById('graphs-container');
							var idDiv = 'graf-cliente-'+cliente.id_cliente;
							var newEl = $('<div/>', {id: idDiv, class: 'graf-tarefas'});
							newEl.appendTo(container);
							graph(idDiv, cliente);
						})
					},
					error: function(xhr, status, error) {
						console.log(xhr);
						alert('Algo correu mal! Tente de novo por favor.');
					}	
		});
	}
			
	function graph(id, datacliente){
        console.log(datacliente);
	  //Meter titulo do cliente
	  //document.getElementById(id).append('<h4>'+datacliente.nome+'</h4>')
		
      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
          //Se o valor de horas do mês for nulo, vamos meter 0
		  var janeiro = typeof datacliente.Janeiro[0] !== "undefined" ? parseInt(datacliente.Janeiro[0], 10) : 0;
		  var fevereiro = typeof datacliente.Fevereiro[0] !== "undefined" ? parseInt(datacliente.Fevereiro[0], 10) : 0;
		  var marco = typeof datacliente.Marco[0] !== "undefined" ? parseInt(datacliente.Marco[0], 10) : 0;
		  var abril = typeof datacliente.Abril[0] !== "undefined" ? parseInt(datacliente.Abril[0], 10) : 0;
		  var maio = typeof datacliente.Maio[0] !== "undefined" ? parseInt(datacliente.Maio[0], 10) : 0;
		  var junho = typeof datacliente.Junho[0] !== "undefined" ? parseInt(datacliente.Junho[0], 10) : 0;
		  var julho = typeof datacliente.Julho[0] !== "undefined" ? parseInt(datacliente.Julho[0], 10) : 0;
		  var agosto = typeof datacliente.Agosto[0] !== "undefined" ? parseInt(datacliente.Agosto[0], 10) : 0;
		  var setembro = typeof datacliente.Setembro[0] !== "undefined" ? parseInt(datacliente.Setembro[0], 10) : 0;
		  var outubro = typeof datacliente.Outubro[0] !== "undefined" ? parseInt(datacliente.Outubro[0], 10) : 0;
		  var novembro = typeof datacliente.Novembro[0] !== "undefined" ? parseInt(datacliente.Novembro[0], 10) : 0;
		  var dezembro = typeof datacliente.Dezembro[0] !== "undefined" ? parseInt(datacliente.Dezembro[0], 10) : 0;
          var bolsaHorasCliente = parseInt(datacliente.horas_mensais, 10)
          //Se as horas forem inferiores ao estabelecido pela avença metemos cor azul, senao metemos vermelho
          var corJan = janeiro<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corFev = fevereiro<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corMar = marco<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corAbr = abril<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corMai = maio<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corJun = junho<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corJul = julho<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corAgo = agosto<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corSet = setembro<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corOut = outubro<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corNov = novembro<bolsaHorasCliente ? '#2196f3' : '#e51c23';
          var corDez = dezembro<bolsaHorasCliente ? '#2196f3' : '#e51c23';


        var data = google.visualization.arrayToDataTable([
            ['Mês', 'Horas', { role: 'style' }],
            ['Janeiro', janeiro, corJan],
            ['Feveireiro', fevereiro, corFev],
            ['Março', marco, corMar],
            ['Abril', abril, corAbr],
            ['Maio', maio, corMai],
            ['Junho', junho, corJun],
            ['Julho', julho, corJul],
            ['Agosto', agosto, corAgo],
            ['Setembro', setembro, corSet],
            ['Outubro', outubro, corOut],
            ['Novembro', novembro, corNov],
            ['Dezembro', dezembro, corDez]
        ]);


        // Set chart options
        var options = {'title': datacliente.nome+' - '+bolsaHorasCliente+' Horas Mensais',
                       'width':'100%',
					   'height':'auto',
					   'backgroundColor': '#fff',
                       'colors': ['#2196f3'],
                       'vAxis': {
                            'gridlines': {
                                'color': 'transparent'
                            }
                        },
                        'titleTextStyle': {
                            'color': '#5a5454',
                            'fontSize': 16,
                        },
                        'axisTextStyle': {
                            'color': 'red',
                            'fontSize': 30
                        }
                       };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById(id));
        chart.draw(data, options);
        var divPrint = document.createElement("div");
        divPrint.innerHTML = '<a href="' + chart.getImageURI() + '">Download</a>';
        divPrint.setAttribute('id', 'print-'+id);
        divPrint.setAttribute('class', 'print-graf');
        //divPrint.appendChild(textnode);
        document.getElementById(id).appendChild(divPrint);
	  }

	}


     function openInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus();
    }

    </script>

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><i class="fa fa-users icons-header" title="Clientes" aria-hidden="true" style="color:#2196f3 !important;"></i> &nbsp;Todos os <strong>Clientes Avençados</strong></h3>

<div class="local-nav">
	<a href="#" class="anchor-ano" onClick="return verAno();">Ver por Ano</a> | <a href="#" class="anchor-mes anchor-bold" onClick="return verMes();">Ver por Mês</a>
</div>

<div class="input-mes" id="filtros-mes">

	<form name="pesquisa" action="" method="POST">

			<select name="mes" class="pesquisa-tarefas-ajax" style="margin-left:10px;">
				<option disabled selected>Mês</option>
				<option value="01">Janeiro</option>
				<option value="02">Fevereiro</option>
				<option value="03">Março</option>
				<option value="04">Abril</option>
				<option value="05">Maio</option>
				<option value="06">Junho</option>
				<option value="07">Julho</option>
				<option value="08">Agosto</option>
				<option value="09">Setembro</option>
				<option value="10">Outubro</option>
				<option value="11">Novembro</option>
				<option value="12">Dezembro</option>
			</select>
			
			<input type="submit" name="pesquisa-avenca-mes" value="Ir" class="liente">
	</form>

	<h4 class="selected-month"><?php echo $nomemes; ?></h4>

</div>

<div id="mes">

<?php

$obj = new classes_DbManager ();

$dado = $obj-> listarClientesAvenca();

while($dados= $dado->fetch(PDO::FETCH_ASSOC)){

$countTarefas = $obj->contarTarefasClienteAvenca($dados['id_cliente']);

$getHorasCliente = $obj->HorasClienteMes($dados['id_cliente'], $mes);

$hours1 = substr($getHorasCliente,0,2);
$minutes1 = substr($getHorasCliente,3,2);
$arrHoras = explode(":",$getHorasCliente);
$hours = $arrHoras[0];
$minutes = $arrHoras[1];
$horasCliente = $hours.'h:'.$minutes.'m';
$horascertas = $hours.'.'.$minutes;
$horasWidth = 100*$horascertas / $dados['horas_mensais'];
if($horascertas > $dados['horas_mensais']){
	$bg = 'red';
}
else{
	$bg = '#2196f3';
}
 ?>

	<div class="row row-list" style="margin: 5vh auto;">

		<div class="col-md-2"><h2><strong>Cliente</strong> <br><br><?php echo $dados['nome']; ?> </h2></div>
		<div class="col-md-2"><h2><strong>Tarefas Avençadas</strong> <br><br><?php echo $countTarefas; ?> </h2></div>
		<div class="col-md-2"><h2><strong>Ver Tarefas</strong><br><br><a href = "list_tarefas.php?cliente=<?php echo $dados['id_cliente']; ?>"><button type="button" class="btn btn-info">Ver</button></a></h2></div>
		<div class="col-md-4">
			<h2>
				<strong>Horas Mensais</strong>
				<br><br>
				<?php echo $horasCliente.' / '.$dados['horas_mensais'].'h';?>
			</h2>
			<div class="counter-horas"><div class="barra-horas" style="width:<?php echo $horasWidth; ?>%;background-color:<?php echo $bg; ?>;"></div></div>
		</div>
		<div class="col-md-2"><h2><strong>Eliminar Cliente</strong> <br><br><a href = "delete_cliente.php?cliente=<?php echo $dados['id_cliente']; ?>" onclick="return checkDelete()"><button type="button" class="btn btn-danger">X</button></a></h2> </div>

	</div>
  <?php }?>

  </div>






  <div id="ano" class="nodisplay">
  
  	<div id="graphs-container"></div>
  
  </div>

</div>


<script>
 function verAno(){
	 iniciarGrafs()
	 $('#ano').removeClass('nodisplay');
	 $('#filtros-mes').addClass('nodisplay');
	 $('#mes').addClass('nodisplay');
	 $('.anchor-ano').addClass('anchor-bold');
	 $('.anchor-mes').removeClass('anchor-bold');
 }

 function verMes(){
	 $('#ano').addClass('nodisplay');
	 $('#filtros-mes').removeClass('nodisplay');
	 $('#mes').removeClass('nodisplay');
	 $('.anchor-ano').removeClass('anchor-bold');
	 $('.anchor-mes').addClass('anchor-bold');
 }
</script>
</body>
</html>
