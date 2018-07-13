<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>

<style>


#alternar-estado-nao-faturado:checked ~.nao-faturado{
  display:block;
}

#alternar-estado-nao-faturado:checked ~.faturado{
  display:none;
}

#alternar-estado-nao-faturado:checked ~.avenca{
  display:none;
}

#alternar-estado-nao-faturado:checked ~.porprocessar{
  display:none;
}

#alternar-estado-faturado:checked ~.faturado{
  display:block;
}

#alternar-estado-faturado:checked ~.nao-faturado{
  display:none;
}

#alternar-estado-faturado:checked ~.avenca{
  display:none;
}

#alternar-estado-faturado:checked ~.porprocessar{
  display:none;
}

#alternar-estado-avenca:checked ~.avenca{
  display:block;
}

#alternar-estado-avenca:checked ~.nao-faturado{
  display:none;
}

#alternar-estado-avenca:checked ~.faturado{
  display:none;
}

#alternar-estado-avenca:checked ~.porprocessar{
  display:none;
}

#alternar-estado-por-processar:checked ~.porprocessar{
	display:block;
}

#alternar-estado-por-processar:checked ~.avenca{
	display:none;
}

#alternar-estado-por-processar:checked ~.nao-faturado{
	display:none;
}

#alternar-estado-por-processar:checked ~.faturado{
	display:none;
}


#alternar-estado-nao-faturado{
  margin-left:3vw;
}

#alternar-estado-faturado{
  margin-left:3vw;
}

#alternar-estado-avenca{
  margin-left:3vw;
}

#alternar-estado-por-processar{
  margin-left:3vw;
}

.pesquisa-tarefas-ajax{
	margin-left:3vw;
	height: 40px !important;
	border-radius: 3px !important;
	border: 1px solid #cccc;
    margin-right: 5px;
    text-indent: 10px;
    margin-bottom: 15px;
}

.icon-faturacao{
	font-size: 30px;
    color: #5093e1;
    position: relative;
    top: 40px;
}

.check-faturacao{
	color:green;
}

.times-faturacao{
	color:red;
}

.check-naofat{
	color:#e6ce50;
}

.btn-pesquisa-cliente{
	background-color:#5093e1;
	border:none;
	border-radius:2px;
	color:#fff;
	height:40px;
	width:40px;
	transition:all .5s ease;
}

.btn-pesquisa-cliente:hover{
	border:1px solid #5093e1;
	background:transparent;
	color:#5093e1;
}

.horas-totais-tarefas-processadas{
	position:absolute;
	background-color:#5093e1;
	color:#fff;
	padding:10px;
	top:0;
	right:50px;
	border-radius:2px;
}

.horas-totais-tarefas-processadas h3{
	margin:0 !important;
	padding:0 !important;
}

.tarefa-processada-highlight{
	border: 2px solid #5093e1;
}

.select-bulk{
	position: absolute;
    top: 0;
    right: 225px;
}

.select-bulk select{
	height: 40px !important;
    border-radius: 3px !important;
    border: 1px solid #cccc;
    margin-right: 5px;
    text-indent: 10px;
    width: 140px;
}

.select-bulk button{
	background-color: #5093e1;
    border: none;
    border-radius: 2px;
    color: #fff;
    height: 40px;
    padding:10px;
    transition: all .5s ease;
}

.select-bulk button:hover{
	border: 1px solid #5093e1;
    background: transparent;
    color: #5093e1;
}
</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();


if($_SESSION['logged_in']!=1){
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
	
	$idtarefa = $_POST['tarefaid'];
	$valfaturacao= $_POST['faturacao'];

	try{		
		$log = new classes_UserManager($myControlPanel);
		$update = $log->updateFaturacaoTarefa($idtarefa, $valfaturacao);
		
	}
	catch (invalidArgumentException $e){

		$e->getMessage();
	}
	
}


?>


<?php include('navbar.php'); ?>
<body class="pagina-tarefas-processadas">

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><span class="icons-header" title="Tarefas" style="font-weight:700;">P</span> &nbsp; Todas as <strong>Tarefas Processadas</strong></h3>


	<form name="pesquisa" action="" method="POST">

<?php	$var = 'teste'; ?>
		<input type="text" id="pesquisa_ajax" name="cliente" class="pesquisa-tarefas-ajax" placeholder="Pesquisar Clientes">

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
		
		<input type="submit" name="pesquisacliente" value="Ir" class="btn-pesquisa-cliente">
	</form>


	<div id="container-tarefas">

		<input type="checkbox" id="alternar-estado-nao-faturado"><label for="alternar-estado-nao-faturado"> &nbsp; Mostrar Tarefas não Faturadas</label>
		<input type="checkbox" id="alternar-estado-faturado"><label for="alternar-estado-faturado"> &nbsp; Mostrar Tarefas já Faturadas</label>
		<input type="checkbox" id="alternar-estado-avenca"><label for="alternar-estado-avenca"> &nbsp; Mostrar Tarefas em Avença</label>
		<input type="checkbox" id="alternar-estado-por-processar"><label for="alternar-estado-por-processar"> &nbsp; Mostrar Tarefas por Tratar</label>

		<?php 

		

					$obj = new classes_DbManager ();
					$mesativo = 0;
					$horastodastarefas = '';
					$minutostodastarefas = '';

			if(empty($_POST['pesquisacliente'])){
						$dado = $obj-> tarefasAjax();
			}
			else{
				$cliente = $_POST['cliente'];
				$mes = $_POST['mes'];
				$dado = $obj-> tarefasAjaxCliente($cliente, $mes);

				if(!empty($mes)){
						$mesativo = $mes;
						
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

				}
			}

					while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
					$process = $dados['processada'];
					$myDb = new classes_DbManager;
					$interv = $obj->_myDb->prepare("Select * from intervenientes_tarefa INNER JOIN users on intervenientes_tarefa.user_interv_id=users.id_user where tarefa_interv_id = '$dados[id_tarefa]'");
					$interv->execute();
					

					if($dados['faturada'] == 0){$selected1 = 'selected'; $selected2 =''; $selected3 =''; $selected4 =''; $class_faturacao = 'nao-faturado'; $iconfaturacao = '<i class="fa fa-check check-naofat icon-faturacao"></i>';}
					else if($dados['faturada'] == 1){$selected1 = ''; $selected2 ='selected'; $selected3 =''; $selected4 =''; $class_faturacao = 'faturado'; $iconfaturacao = '<i class="fa fa-check check-faturacao icon-faturacao"></i>';}
					else if($dados['faturada'] == 2){$selected1 = ''; $selected2 =''; $selected3 ='selected'; $selected4 ='';  $class_faturacao = 'avenca'; $iconfaturacao = '<i class="fa fa-check acordo-faturacao icon-faturacao"></i>';}
					else if($dados['faturada'] == 3){$selected1 = ''; $selected2 =''; $selected3 =''; $selected4 ='selected';  $class_faturacao = 'porprocessar'; $iconfaturacao = '<i class="fa fa-times times-faturacao icon-faturacao"></i>';}
					
		?>

				<div class="row row-list tarefa-processada-single <?php echo $class_faturacao ?> " style="margin: 5vh auto;" id="<?php echo $dados['id_tarefa'];?>">
					<a href = "listar_tarefa.php?id=<?php echo $dados['id_tarefa']?>">
						<div class="col-md-1"> <h5><strong>Cliente</strong> <br><br><?php echo $dados['nome'];?></h5></div>
						<div class="col-md-2"> <h5><strong>Título</strong><br><br><?php echo $dados['titulo'];?></h5></div>
						<div class="col-md-3"> <h5><strong>Intervenientes</strong><br><br>
			<?php while($intervenientes= $interv->fetch(PDO::FETCH_ASSOC)){ ?>
					<img src="img/users/<?php echo $intervenientes['img'] ?>" class="img-circle" width="40px" title="<?php echo $intervenientes['nome_user'] ?>">
			 <?php } ?> 
			</h5></div>
						<div class="col-md-2"><h5>
						<?php if($mesativo == 0){ ?>
							<strong>Horas</strong><br><br>
							<?php
								$horastotais = $obj-> horasAjax($dados['id_tarefa']);
								
								while($horas= $horastotais->fetch(PDO::FETCH_ASSOC)){
									if(!empty($horas['horastotais'])){
									$hours = substr($horas['horastotais'],0,2);
									$minutes = substr($horas['horastotais'],3,2);
									$horastodastarefas += $hours;
									$minutostodastarefas += $minutes;
									echo $hours.'h:'.$minutes.'m';}
									else{
										echo "Sem Horas";
									}
								}
							}
							
							else if($mesativo != 0){ ?>
								<strong>Horas em <?php echo $nomemes ?></strong><br><br>
								<?php
									$horastotaismes = $obj-> horasAjaxMes($dados['id_tarefa'], $mesativo);

									while($horasmes= $horastotaismes->fetch(PDO::FETCH_ASSOC)){
										if(!empty($horasmes['horastotais'])){
										$horasativas = substr($horasmes['horastotais'],0,2);
										$minutosativos = substr($horasmes['horastotais'],3,2);
										$horastodastarefas += $horasativas;
										$minutostodastarefas += $minutosativos;
										echo $horasativas.'h:'.$minutosativos.'m';}
										else{
											echo "Sem Horas";
										}
									}
							}
							?>
						</h5>
						</div>
					</a>
					<div class="col-md-2"> <h5><strong>Faturação</strong> <br><br>
						<form method="POST" action="">
							<select class="form-control" name="faturacao" required>
								<option <?php echo $selected1; ?> value="0">Não faturada</option>
								<option <?php echo $selected2; ?> value="1">Faturada</option>
								<option <?php echo $selected3; ?> value="2">Avença</option>
								<option <?php echo $selected4; ?> value="3">Por Tratar</option>
							</select><br>
							<button type="submit" name="btnestado" id="btncheckestado" style="background-color:transparent; border:none;"><i class="fa fa-check" aria-hidden="true"></i></button>
							<input type="hidden" name="tarefaid" value="<?php echo $dados['id_tarefa']?>">
						</form>
					</div>
					<div class="col-md-2"><?php echo $iconfaturacao; ?></div></div>


		<?php } ?>

	</div>

	

<?php 
while($minutostodastarefas > 60){
		$horastodastarefas += 1;
		$minutostodastarefas -= 60;
	}
?>
<div class="horas-totais-tarefas-processadas" <?php if($horastodastarefas<01 && $minutostodastarefas<01){?> style="display:none;" <?php } ?> >
<h3>
	<?php echo "
		$horastodastarefas"."h:".$minutostodastarefas."m
	" ?>
</h3>
</div>


<div class="select-bulk">
	<select name="selectbulk">
		<option value="0">Não Faturada</option>
		<option value="1">Faturada</option>
		<option value="2">Avença</option>
		<option value="3">Por Tratar</option>
	</select>
	<button id="btn-select-bulk">Submeter</button>
</div>

</div>



</body>

<script>

$('.tarefa-processada-single').click(function(){
	$(this).toggleClass('tarefa-processada-highlight');
});


$('#btn-select-bulk').click(function(){
	$('.tarefa-processada-highlight').each(function(i, obj) {
		var id = $(this).attr('id');		
		var option = $('select[name=selectbulk]').val();
		$.ajax({
            type: "GET",
            url: "http://tarefas.invisual.pt/ajax/bulk-processadas.php",
            data: { 'id': id, 'option': option  },
            success: function(){
                console.log('Sucesso');
            },
			error: function(xhr, status, error) {
				console.log(xhr);
				alert('Algo correu mal! Tente de novo por favor.');
			  }	
        });

	}).promise().done( function(){ setTimeout(function () {
        location.reload()
    }, 100); } );

	
});

</script>

</html>