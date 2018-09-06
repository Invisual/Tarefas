<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>

<style>
body{
	font-family: 'Raleway', sans-serif;
}

.maincf{
	padding-bottom:70px;
}

h3 strong{
    color:#2196f3;
}

.row-filtros{
    margin-right: 1.5%;
    margin-left: 1.5%;
}

.row-filtros .col-md-5{
    text-align:center;
}

.col-md-5 form{
    display:inline-block;
}

.col-md-5 select{
    border-radius: 14px;
    background-color: #f7f7f7;
    border: none;
    height: 40px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    margin-bottom: 15px;
    margin-top: 10px;
    text-indent: 15px;
    display:inline-block;
    margin-left:10px;
    margin-right:10px;
    width: 150px;
}


.row-tarefa-admin{
    margin-top: 40px;
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    padding-bottom: 20px;
    position: relative;
    padding: 20px 0 22px 0;
    color: #333;
    margin-right: 1.5%;
    margin-left: 1.5%;
    overflow: hidden;
}

.row .col-md-1, .row .col-md-2, .row .col-md-3{
    text-align:center;
    font-size: 13px;
    color: #797676;
    font-weight: 500;
}

.row h2{
    color: #5a5454;
    font-weight: 600;
    font-size: 16px;
    letter-spacing:.03em;
}

.estadotarefa-2{
    border-bottom:8px solid black;
}

.tarefa-single-highlight{
		border: 4px solid #5093e1;
}

.btn-ir-tarefa{
    color: #2196f3;
    background-color: transparent;
    border: 2px solid #2196f3;
    font-weight: 600;
    letter-spacing: .05em;
    transition: all .5s ease !important;
}

.btn-ir-tarefa:hover{
    background-color:#2196f3;
    color:#fff;
}

.user-img{
    width:45px;
    border-radius:50%;
}

.faturadatarefa-0 .estadotarefa{
    color: #feea3a;
}

.faturadatarefa-1 .estadotarefa{
    color: #4bae4f;
}

.faturadatarefa-2 .estadotarefa{
    color: #2196f3;
}

.faturadatarefa-3 .estadotarefa{
    color: #f34235;
}

.fixed-bar{
    width: 95%;
    margin: 0 auto;
}

.select-bulk{
    display: inline-block;
    padding-right: 40px;
}

.select-bulk select{
    border-radius: 14px;
    background-color: #f7f7f7;
    border: none;
    height: 40px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    margin-bottom: 15px;
    margin-top: 10px;
    text-indent: 15px;
    display:inline-block;
    margin-left:10px;
    margin-right:10px;
}

.select-bulk button{
    display: inline-block;
    margin-left: 10px;
    margin-right: 10px;
    border-radius: 14px;
    background-color: #2196f3;
    border: 2px solid #2196f3;
    color: #fff;
    height: 40px;
    font-weight: 600;
    transition: all .5s ease;
    letter-spacing: .05em;
    padding: 0 15px 0 15px;
}

#contadorhoras{
    display: inline-block;
    border: 3px solid #2196f3;
    border-radius: 5px;
    padding: 10px;
    color: #2196f3;
    position:absolute;
    right:40px;
    top:0;
}

#contadorhoras h3{
    margin: 0;
    padding: 0;
    font-weight: 600;
    letter-spacing: .05em;
}


@media only screen and (max-width:700px){
    #contadorhoras{
        position:unset;
    }

    .select-bulk {
    margin-top: 50px;
}
}

</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();


$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if($_SESSION['logged_in']!=1){
	header('location:index.php');
}


if($_SESSION['superadmin']!=1){
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




?>


<?php include('navbar.php'); ?>
<body>

<div class="container-fluid maincf" style="position:relative; top:10vh;">

    <h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp; Todas as <strong>Tarefas Processadas</strong></h3>

    <div id="contadorhoras"></div>

    <div class="row row-filtros">
    
        <div class="col-md-5">

            <form id="filtros-form">
                <select name="clientes" id="filtro-cliente">
                    <option value="-" selected>Cliente</option>
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


                <select name="mes" id="filtro-mes">
                    <option value="-">Mês</option>
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


                <select name="faturada" id="filtro-faturada">
                    <option value="-">Estado do Process.</option>
                    <option value="0">Não Faturada</option>
                    <option value="1">Já Faturada</option>
                    <option value="2">Em Avença</option>
                    <option value="3">Por Tratar</option>
                </select>
            </form>
        
        </div>

         <div class="col-md-2"></div>


        <div class="col-md-5">
        
            <div class="select-bulk">
                <select name="selectbulk">
                    <option value="0">Não Faturada</option>
                    <option value="1">Faturada</option>
                    <option value="2">Avença</option>
                    <option value="3">Por Tratar</option>
                </select>   
                <button id="btn-select-bulk" class="btn-submeter-tarefas">Submeter</button>

            </div>

        </div>

    </div>



    <div id="tarefas-container"></div>



</div>



<script>    
$(document).ready(function(){

            var horastodastarefas = 0;
            var minutostodastarefas = 0;
    
        $.ajax({
            type:'POST',
            url:'ajax/listagem_ajax_processadas_all.php',
            dataType: "json",
            success:function(data){
                $.each(data, function(index) {
                    var faturadaName = '';
                    switch(data[index].faturada){
                        case '0':
                        faturadaName = 'Não Faturada';
                        break;

                        case '1':
                        faturadaName = 'Já Faturada';
                        break;

                        case '2':
                        faturadaName = 'Em Avença';
                        break;

                        case '3':
                        faturadaName = 'Por Tratar';
                        break;

                        default:
                        faturadaName = '-';
                        break;
                    }

                    $('#tarefas-container').append(
                        "<div class='row row-tarefa-admin faturadatarefa-"+data[index].faturada+"' id='"
                        +data[index].id_tarefa+"'><div class='col-md-2'><h2>Cliente</h2> <br> "
                        +data[index].nome+"</div><div class='col-md-2'><h2>Título</h2> <br> "
                        +data[index].titulo+"</div><div class='col-md-2'><h2>Descrição</h2> <br> "
                        +data[index].descricao.substring(0, 60) + "..."+"</div><div class='col-md-1'><h2>Estado</h2> <br> <p class='estadotarefa'>"
                        +faturadaName+"</p></div><div class='col-md-1' id='horas-"
                        +data[index].id_tarefa+"'><h2>Horas</h2> <br></div><div class='col-md-2' id='intervenientes-"
                        +data[index].id_tarefa+"'><h2>Intervenientes</h2> <br></div><div class='col-md-2'><h2>Ver Tarefa</h2><br><a href='listar_tarefa.php?id="
                        +data[index].id_tarefa+"'><button class='btn main-btn btn-ir-tarefa'>Ir</button></a></div></div>");


                         $.ajax({
                            type:'POST',
                            url:'ajax/get_intervenientes_tarefa.php',
                            dataType: "json",
                            data:{tarefa: data[index].id_tarefa},
                            success:function(data){
                                $.each(data, function(index) {
                                    $('#intervenientes-'+data[index].tarefa_interv_id).append("<img class='user-img' alt='"+data[index].nome_user+"' title='"+data[index].nome_user+"' src='img/users/"+data[index].img+"' />");
                                });  
                            }
                         });


						 $.ajax({
                            type:'POST',
                            url:'ajax/get_horas_tarefa.php',
                            dataType: "json",
                            data:{tarefa: data[index].id_tarefa, mes:0},
                            success:function(data){
                                $.each(data, function(index) {
                                    var horastotais = data[index].horastotais.substring(0,2);
                                    var minutostotais = data[index].horastotais.substring(3,5);
                                    $('#horas-'+data[index].tarefa).append("<p>"+horastotais+"h:"+minutostotais+"m</p>");
                                    var horastotaisint = parseInt(horastotais,10);
                                    var minutostotaisint = parseInt(minutostotais,10);
                                    horastodastarefas += horastotaisint;
                                    minutostodastarefas += minutostotaisint;
                                });  
                            },
                            complete: function(){
                                while(minutostodastarefas > 60){
		                            horastodastarefas += 1;
		                            minutostodastarefas -= 60;
	                            }
                                console.log(horastodastarefas+"h:"+minutostodastarefas+"m");
                                $('#contadorhoras').empty();
                                $('#contadorhoras').append('<h3>'+horastodastarefas+'h:'+minutostodastarefas+'m</h3>');
                            }
                         });


                });

            }
        });

});
</script>


<script>


$('#filtros-form').change(function(){
    $('#tarefas-container').empty();

    var clienteVal = document.getElementById('filtro-cliente').value;
    var mesVal = document.getElementById('filtro-mes').value;
    var faturadaVal = document.getElementById('filtro-faturada').value;
    var horastodastarefas = 0;
    var minutostodastarefas = 0;

    $.ajax({
            type:'POST',
            url:'ajax/listagem_ajax_processadas_filtros.php',
            dataType: "json",
            data:{cliente: clienteVal, mes: mesVal, faturada: faturadaVal},
            success:function(data){
                $.each(data, function(index) {
                    var faturadaName = '';
                    switch(data[index].faturada){
                        case '0':
                        faturadaName = 'Não Faturada';
                        break;

                        case '1':
                        faturadaName = 'Já Faturada';
                        break;

                        case '2':
                        faturadaName = 'Em Avença';
                        break;

                        case '3':
                        faturadaName = 'Por Tratar';
                        break;

                        default:
                        faturadaName = '-';
                        break;
                    }

                    $('#tarefas-container').append(
                        "<div class='row row-tarefa-admin faturadatarefa-"+data[index].faturada+"' id='"
                        +data[index].id_tarefa+"'><div class='col-md-2'><h2>Cliente</h2> <br> "
                        +data[index].nome+"</div><div class='col-md-2'><h2>Título</h2> <br> "
                        +data[index].titulo+"</div><div class='col-md-2'><h2>Descrição</h2> <br> "
                        +data[index].descricao.substring(0, 60) + "..."+"</div><div class='col-md-1'><h2>Estado</h2> <br> <p class='estadotarefa'>"
                        +faturadaName+"</p></div><div class='col-md-1' id='horas-"
                        +data[index].id_tarefa+"'><h2>Horas</h2> <br></div><div class='col-md-2' id='intervenientes-"
                        +data[index].id_tarefa+"'><h2>Intervenientes</h2> <br></div><div class='col-md-2'><h2>Ver Tarefa</h2><br><a href='listar_tarefa.php?id="
                        +data[index].id_tarefa+"'><button class='btn main-btn btn-ir-tarefa'>Ir</button></a></div></div>");


                         $.ajax({
                            type:'POST',
                            url:'ajax/get_intervenientes_tarefa.php',
                            dataType: "json",
                            data:{tarefa: data[index].id_tarefa},
                            success:function(data){
                                $.each(data, function(index) {
                                    $('#intervenientes-'+data[index].tarefa_interv_id).append("<img class='user-img' alt='"+data[index].nome_user+"' title='"+data[index].nome_user+"' src='img/users/"+data[index].img+"' />");
                                });  
                            }
                         });

                         $.ajax({
                            type:'POST',
                            url:'ajax/get_horas_tarefa.php',
                            dataType: "json",
                            data:{tarefa: data[index].id_tarefa, mes:0},
                            success:function(data){
                                $.each(data, function(index) {
                                    var horastotais = data[index].horastotais.substring(0,2);
                                    var minutostotais = data[index].horastotais.substring(3,5);
                                    $('#horas-'+data[index].tarefa).append("<p>"+horastotais+"h:"+minutostotais+"m</p>");
                                    var horastotaisint = parseInt(horastotais,10);
                                    var minutostotaisint = parseInt(minutostotais,10);
                                    horastodastarefas += horastotaisint;
                                    minutostodastarefas += minutostotaisint;
                                });
                               
                            },
                            complete: function(){
                                while(minutostodastarefas > 60){
		                            horastodastarefas += 1;
		                            minutostodastarefas -= 60;
	                            }
                                console.log(horastodastarefas+"h:"+minutostodastarefas+"m");
                                $('#contadorhoras').empty();
                                $('#contadorhoras').append('<h3>'+horastodastarefas+'h:'+minutostodastarefas+'m</h3>');
                            }
                         });
                        

                });
                if (!$.trim(data)){
                    $('#tarefas-container').append('<h2 style="text-align:center; margin-top:75px;">Sem dados...</h2>');
                }
            }
        });

    

});
</script>


<script>
$(document).on('click', '.row-tarefa-admin', function()
{
    $(this).toggleClass('tarefa-single-highlight');
});


$('#btn-select-bulk').click(function(){
	$('.tarefa-single-highlight').each(function(i, obj) {
		var id = $(this).attr('id');		
		var option = $('select[name=selectbulk]').val();
		$.ajax({
            type: "GET",
            url: "./ajax/bulk-processadas.php",
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


</body>



</html>