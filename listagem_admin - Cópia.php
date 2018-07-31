<?php include('headers.php'); ?>
<title>INVISUAL - Tarefas</title>

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

	$myControlPanel->setMyDb(classes_DbManagder::ob());

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

        <div id="tarefas-container"></div>



    </div>




<script>

$(document).ready(function(){
    
        $.ajax({
            type:'POST',
            url:'ajax/listagem_ajax_admin.php',
            dataType: "json",
            data:{cliente:1, user:1, estado:1},
            success:function(data){
                $.each(data, function(index) {
                    var estadoName = '';
                    switch(data[index].estado){
                        case 0:
                        estadoName = 'Por Iniciar';
                        break;

                        case 1:
                        estadoName = 'Em Curso';
                        break;

                        case 2:
                        estadoName = 'Concluída';
                        break;

                        case 3:
                        estadoName = 'Pausa';
                        break;

                        case 4:
                        estadoName = 'Aguarda Aprovação Interna';
                        break;

                        case 5:
                        estadoName = 'Aguarda Aprovação Externa';
                        break;

                        default:
                        estadoName = '-';
                        break;
                    }

                    $('#tarefas-container').append(
                        "<div class='row'><div class='col-md-1'>Cliente <br> "
                        +data[index].cliente_id+"</div><div class='col-md-1'>Título <br> "
                        +data[index].titulo+"</div><div class='col-md-1'>Descrição <br> "
                        +data[index].descricao+"</div><div class='col-md-1'>Estado <br> "
                        +data[index].estado+"</div></div>");
                });
            }
        });

});

</script>


</body>

</html>