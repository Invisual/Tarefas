<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>

<style>
body{
	font-family: 'Raleway', sans-serif;
}

h3 strong{
    color:#2196f3;
}

.filtros{
    width: 95%;
    margin:0 auto;
}

.filtros form{
    display:inline-block;
}

.filtros select{
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

.filtros #btn-processar-bulk{
    display:inline-block;
    margin-left:10px;
    margin-right:10px;
    border-radius: 14px;
    background-color: #2196f3;
    border:2px solid #2196f3;
    color:#fff;
    height: 40px;
    font-weight: 600;
    transition: all .5s ease;
    letter-spacing: .05em;
    padding: 0 15px 0 15px;
}

.filtros #btn-processar-bulk:hover{
    background-color: #fff;
    color:#2196f3;
}

.row{
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

<div class="container-fluid" style="position:relative; top:10vh;">

    <h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp; Todas as <strong>Tarefas</strong></h3>


    <div class="filtros">

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

            <select name="users" id="filtro-user">
                <option value="-" selected>Colaboradores</option>
				<?php
				$myDb = new classes_DbManager;
				$query = $myDb->_myDb->prepare("Select * from users where inativo != '1' order by nome_user");
				$query->execute();
				while($row = $query->fetch(PDO::FETCH_ASSOC))
					{
					echo "<option value=".$row['id_user'].">".$row['nome_user']."</option>";
					}
				?>
            </select>

            <select name="estado" id="filtro-estado">
                <option value="-">Estado</option>
                <option value="0">Por Iniciar</option>
                <option value="1">Em Curso</option>
                <option value="2">Concluída</option>
                <option value="3">Pausa</option>
                <option value="4">Aguarda Aprovação Interna</option>
                <option value="5">Aguarda Aprovação Externa</option>
            </select>

        </form>

        <button id="btn-processar-bulk">Processar Tarefas</button>

    </div>

    <div id="tarefas-container"></div>



</div>



<script>    
$(document).ready(function(){
    
        $.ajax({
            type:'POST',
            url:'ajax/listagem_ajax_admin_all.php',
            dataType: "json",
            data:{cliente:1, user:1, estado:1},
            success:function(data){
                $.each(data, function(index) {
                    var estadoName = '';
                    switch(data[index].estado){
                        case '0':
                        estadoName = 'Por Iniciar';
                        break;

                        case '1':
                        estadoName = 'Em Curso';
                        break;

                        case '2':
                        estadoName = 'Concluída';
                        break;

                        case '3':
                        estadoName = 'Pausa';
                        break;

                        case '4':
                        estadoName = 'Aguarda Aprovação Interna';
                        break;

                        case '5':
                        estadoName = 'Aguarda Aprovação Externa';
                        break;

                        default:
                        estadoName = '-';
                        break;
                    }

                    $('#tarefas-container').append(
                        "<div class='row row-tarefa-admin estadotarefa-"+data[index].estado+"' id='"
                        +data[index].id_tarefa+"'><div class='col-md-2'><h2>Cliente</h2> <br> "
                        +data[index].nome+"</div><div class='col-md-2'><h2>Título</h2> <br> "
                        +data[index].titulo+"</div><div class='col-md-2'><h2>Descrição</h2> <br> "
                        +data[index].descricao.substring(0, 60) + "..."+"</div><div class='col-md-1'><h2>Estado</h2> <br> "
                        +estadoName+"</div><div class='col-md-3' id='intervenientes-"
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


                });

            }
        });

});
</script>


<script>
$('#filtros-form').change(function(){
    $('#tarefas-container').empty();

    var clienteVal = document.getElementById('filtro-cliente').value;
    var userVal = document.getElementById('filtro-user').value;
    var estadoVal = document.getElementById('filtro-estado').value;


    $.ajax({
            type:'POST',
            url:'ajax/listagem_ajax_admin_filtros.php',
            dataType: "json",
            data:{cliente: clienteVal, user: userVal, estado: estadoVal},
            success:function(data){
                $.each(data, function(index) {
                    var estadoName = '';
                    switch(data[index].estado){
                        case '0':
                        estadoName = 'Por Iniciar';
                        break;

                        case '1':
                        estadoName = 'Em Curso';
                        break;

                        case '2':
                        estadoName = 'Concluída';
                        break;

                        case '3':
                        estadoName = 'Pausa';
                        break;

                        case '4':
                        estadoName = 'Aguarda Aprovação Interna';
                        break;

                        case '5':
                        estadoName = 'Aguarda Aprovação Externa';
                        break;

                        default:
                        estadoName = '-';
                        break;
                    }

                    $('#tarefas-container').append(
                        "<div class='row row-tarefa-admin estadotarefa-"+data[index].estado+"' id='"
                        +data[index].id_tarefa+"'><div class='col-md-2'><h2>Cliente</h2> <br> "
                        +data[index].nome+"</div><div class='col-md-2'><h2>Título</h2> <br> "
                        +data[index].titulo+"</div><div class='col-md-2'><h2>Descrição</h2> <br> "
                        +data[index].descricao.substring(0, 60) + "..."+"</div><div class='col-md-1'><h2>Estado</h2> <br> "
                        +estadoName+"</div><div class='col-md-3' id='intervenientes-"
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


$('#btn-processar-bulk').click(function(){
	$('.tarefa-single-highlight').each(function(i, obj) {
		var id = $(this).attr('id');		
		$.ajax({
            type: "GET",
            url: "http://localhost/tarefas/ajax/bulk-tarefas-concluidas.php",
            data: { 'id': id },
            success: function(){
                console.log(id);
            },
			error: function(xhr, status, error) {
				console.log(xhr);
			  }
        });

	}).promise().done( function(){ setTimeout(function () {
        location.reload();
        alert('As Tarefas foram processadas !');
    }, 100); } );

	
});
</script>


</body>



</html>