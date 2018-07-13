<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>

<style>

form{
        padding-left: 7%;
            padding-top: 50px;
                width: 50%;
    margin: 0 auto;
}

select{
        width: 100%;
    height: 40px !important;
    border-radius: 3px !important;
    border: 1px solid #cccc;
    margin-right: 5px;
    text-indent: 10px;
    margin-bottom: 15px;
}

.input-holder{
    font-size: 18px;
    padding-top: 10px;
    padding-bottom: 10px;
        padding-left: 15px;
}

.input-holder label{
        padding-left: 10px;
            font-weight:600;
}

#select-tarefas{
        padding-top: 20px;
    padding-bottom: 20px;
}

form h5{
    color: #5093e1;
    font-size: 15px;
}

#submit-button{
    text-align:center;
}

input[type="submit"]{
    background-color: #5093e1;
    border: none;
    border-radius: 2px;
    color: #fff;
    height: 40px;
        padding: 0 10px;
    transition: all .5s ease;
        margin-top: 20px;
}

input[type="submit"]:hover{
        border: 1px solid #5093e1;
    background: transparent;
    color: #5093e1;
}

h3 strong {
    color: #5093e1;
}

.anchor-tarefa{
        font-size: 13px;
    padding-left: 15px;
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
	$valfaturacao = $_POST['value'];
	$maximo = count($_POST["tarefas-bulk"]);
	for($i=0;$i<$maximo;$i++)
{
		try{		
			$log = new classes_UserManager($myControlPanel);
			$update = $log->updateFaturacaoTarefa($_POST["tarefas-bulk"][$i], $valfaturacao);
			echo "<script>alert('A operação foi efectuada com sucesso !')</script>";
		}
		catch (invalidArgumentException $e){
			$e->getMessage();
			echo "<script>alert('Algo correu mal. Tente de novo!')</script>";
		}
	}

}

?>


<?php include('navbar.php'); ?>
<body class="pagina-tarefas-processadas-bulk">

<div class="container-fluid" style="position:relative; top:10vh;">

<h3 class="page-header"><span class="icons-header" title="Tarefas" style="font-weight:700;">P</span> &nbsp; Ações em <strong>Massa</strong></h3>

<form method="POST" action="">
    <h5>Escolha um Cliente</h5>
	<select id="select-clientes" name="clientes" onchange="checkCliente(this)">

		<?php 
			$obj = new classes_DbManager ();
			$dado = $obj-> listarClientes();
			while($dados= $dado->fetch(PDO::FETCH_ASSOC)){
				$countTarefasCliente = $obj->contarTarefasClienteProcessadas($dados['id_cliente']);
		?>

			<option class="option-select-clientes" value="<?php echo $dados['id_cliente']?>"><?php echo $dados['nome'].'&nbsp; - &nbsp;'.$countTarefasCliente?></option>

		<?php } ?>

	</select>



	<div id="select-tarefas"></div>

	<div id="select-bulk"></div>

	<div id="submit-button"></div>
	
	<div id="placeholder-frase"></div>


	</form>	

</div>



</body>


<script>
function checkCliente(selectObject) {
	$('#select-tarefas').empty()
	$('#select-bulk').empty();
	$('#submit-button').empty();
	$('#placeholder-frase').empty();
    var value = selectObject.value; 
	$.ajax({
            type: "POST",
            url: "https://tarefas.invisual.pt/ajax/ajax-clientes.php",
            data: { 'id': value  },
            success: function(data){
                if(!data || 0 === data.length){
                    $('#placeholder-frase').append('<h4>Este cliente não tem de momento Tarefas processadas não faturadas.</h4>');
                }
                else{
								$('#select-bulk').append('<select name="value"><option value="0">Não Faturada</option><option value="1">Faturada</option><option value="2">Avença</option><option value="3">Por Tratar</option></select>');
								$('#submit-button').append('<input type="submit" value="Submeter">');
                $.each(data, function(i, d) {
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
										$('#select-tarefas').append('<div class="input-holder"><input type="checkbox" id="check-tarefas-'+ d.id_tarefa +'" name="tarefas-bulk[]" value="'+ d.id_tarefa +'"><label for="check-tarefas-'+ d.id_tarefa +'">'+ d.titulo +'</label><a href="http://tarefas.invisual.pt/listar_tarefa.php?id='+d.id_tarefa+'" class="anchor-tarefa" target="_blank">Ver Tarefa</a></div>');
										
                });
                }
            }
        });
}


</script>

</html>