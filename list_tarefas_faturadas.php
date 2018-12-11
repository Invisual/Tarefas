<?php include('headers.php'); ?>
    <title>INVISUAL - Tarefas Faturadas</title>
    <script src="https://tarefas.invisual.pt/js/moment.js"></script>
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


    .col-md-12 form{
        display:inline-block;
    }

    .col-md-12 select{
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

    .estado-2{
        display: block;
        border-bottom: 5px solid #333;
    }

    .tipo-1{
        border-bottom: 5px solid #feea3a;
    }

    .tipo-2{
        border-bottom: 5px solid #06aaf5;
    }

    .tarefa-single-highlight{
            border: 4px solid #5093e1;
    }

    .btn-primary{
        background-color: #2196f3 !important;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
        color: #fff !important;
        border: none !important;
        position: relative;
    }

    .btn-ir-tarefa, .btn-processar-tarefa{
        color: #2196f3;
        background-color: transparent;
        border: 2px solid #2196f3;
        font-weight: 600;
        letter-spacing: .05em;
        transition: all .5s ease !important;
    }

    .btn-ir-tarefa:hover, .btn-processar-tarefa:hover{
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

    .contador{
        display: inline-block;
        border: 3px solid #2196f3;
        border-radius: 5px;
        padding: 10px;
        color: #2196f3;
        position:absolute;
        right:40px;
    }

    .contador h3{
        margin: 0;
        padding: 0;
        font-weight: 600;
        letter-spacing: .05em;
    }

    #contadorhoras{
        top:0;
    }

    #contadorhoras-highlighted{
        top:65px;
        border:none;
        background-color:#2196f3;
        color:#fff;
    }

    .nodisplay{
        display:none;
    }

    #tarefas-container .text-center{
        margin-top:100px;
    }

    .horas-tarefas-seleccionadas{
        display:inline-block;
        font-weight: 600;
        color: #2196f3;
        font-size: 20px;
        padding: 0;
        margin: 0;
    }

    .check-faturada{
        font-size: 28px;
        position: relative;
        top: 2px;
        color: #4CAF50;
    }

    .faturadatarefa-2 .col-fat, .faturadatarefa-4 .col-fat{
        opacity:.4;
        pointer-events:none !important;
    }

    #btn-processar-bulk{
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

    .modal-tarefa{
	    margin: auto;
        position: absolute;
        top: 25%;
        left: 0;
        right: 0;
        background-color: #fff;
        border-radius: 14px;
        box-shadow: 0 -5px 15px rgba(0,0,0,0.16), 0 22px 16px rgba(0,0,0,0.23);
        width: 40%;
        padding: 30px 25px 20px 25px;
        text-align: center;
        opacity: 0;
        display:none;
}

.mostrar-modal{
	display:block;
	animation: mostrarModal .3s ease-in;
	animation-fill-mode: forwards;
}

@keyframes mostrarModal{
	0%{
		opacity:0;
	}
	100%{
		opacity:1;
	}
}

.close-modal{
	position: absolute;
    right: 11px;
    top: 6px;
    font-weight: 800;
    font-size: 1.2em;
    color: #666;
	cursor:pointer;
}

.modal-tarefa label{
	display:block;
	text-align:left;
	width:90%;
	margin:0 auto 10px auto;
	color: #666;
    letter-spacing: .02em;
}

.modal-tarefa textarea{
	width:90%;
	margin:0 auto;
	border-radius: 7px;
    background-color: #f7f7f7;
    border: none;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    text-indent: 15px;
	height:70px;
}

.modal-tarefa button{
	font-weight: 600;
    letter-spacing: .02em;
    border-radius: 7px;
}

    @media screen and (max-width: 767px){

        .listagem-tarefas-processadas .row-tarefa-admin .col-desc, .listagem-tarefas-processadas .row-tarefa-admin .col-intervenientes, .listagem-tarefas-processadas .row-tarefa-admin .col-desc, .listagem-tarefas-processadas .row-tarefa-admin br{
            display:none;
        }
        
        .listagem-tarefas-processadas .row-tarefa-admin h2{
            display:inline-block;
            margin-right: 8px;
            margin-top:10px;
        }

        .listagem-tarefas-processadas .row-tarefa-admin p, .listagem-tarefas-processadas .row-tarefa-admin .checkfat{
            display:inline-block;
        }

        .listagem-tarefas-processadas .row-tarefa-admin .btn-ir-tarefa{
            border: none;
            padding: 0 5px !important;
            position: relative;
            bottom: 1px;
        }

        .listagem-tarefas-processadas .row-tarefa-admin .checkfat{
            position: relative;
            top: 4px;
        }
    }

    @media only screen and (max-width:700px){
        #contadorhoras, #contadorhoras-highlighted{
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
    $iduser = $_SESSION['id'];

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
    <body class="listagem-tarefas-processadas">

    <div class="container-fluid maincf" style="position:relative; top:10vh;">

        <h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp; Todas as <strong>Tarefas Faturadas</strong></h3>

        <div class="row row-filtros">
        
            <div class="col-md-12">

                <form id="filtros-form">

                    <select name="clientes" id="filtro-cliente">
                        <option value="" selected>Cliente</option>
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
                        <option value="">Mês</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>

                </form>

            
            </div>

        </div>



        <div id="tarefas-container"></div>



    </div>

    <script>    
    $(document).ready(function(){

            //Definir todas as variáveis iniciais que vamos precisar
            var arrTarefasInteiro;

            var options = {
                cliente: '',
                mes: ''
            }


            //Definir Função que vai ser chamada no AJAX e vai ser chamada sempre que haja mudança num dos select
            function assignDataToArray(){

                //Inicialmente, limpamos todas as tarefas na DIV contentor
                $('#tarefas-container').empty();
                
                //Criamos uma nova variável que vai guardar o array que vem do AJAX, mas filtrado com os filtros desejados
                arrTarefas = arrTarefasInteiro.tarefas.filter(tar => (
                    tar.id_cliente.includes(options.cliente) && tar.data.substr(5,2).includes(options.mes)
                ));


                //Loop para percorrer este array filtrado
                for(var i = 0, count=arrTarefas.length; i<count; i++){

                    var dataExtenso = arrTarefas[i].data;
                    var dia = dataExtenso.substr(8,2);
                    var mes = dataExtenso.substr(5,2);
                    var ano = dataExtenso.substr(0,4);
                    var dataCompleta = dia+'/'+mes+'/'+ano;

                    var resultadoTotalTarefa = 0;
                    var valorFornecedorTarefa = 0;
                    var valorVendaTarefa = 0;
                    for(var x=0, countX = arrTarefas[i].custos.length; x<countX; x++){
                        var tempId = arrTarefas[i].custos[x];
                        var resultadoTemp = arrTarefasInteiro.custos[tempId].custov - arrTarefasInteiro.custos[tempId].custof;
                        valorFornecedorTarefa += parseInt(arrTarefasInteiro.custos[tempId].custof,10);
                        valorVendaTarefa += parseInt(arrTarefasInteiro.custos[tempId].custov,10);
                        resultadoTotalTarefa += resultadoTemp;
                    }

                    var valorFornecedorFinal = valorFornecedorTarefa > 0 ? valorFornecedorTarefa+'€' : '-';
                    var valorVendaFinal = valorVendaTarefa > 0 ? valorVendaTarefa+'€' : '-';
                    var resultadoFinal = resultadoTotalTarefa > 0 ? resultadoTotalTarefa+'€' : '-';
                    

                        $('#tarefas-container').append(
                            "<div class='row row-tarefa-admin tipo-"+arrTarefas[i].tipo_tarefa+"' id='"
                            +arrTarefas[i].id_tarefa+"'><div class='col-md-2 col-cliente'><h2>Cliente</h2> <br> "
                            +arrTarefas[i].nome+"</div><div class='col-md-2 col-titulo'><h2>Título</h2> <br> "
                            +arrTarefas[i].titulo+"</div><div class='col-md-2 col-user-fat'><h2>Faturada por</h2> <br> <img class='user-img' src='img/users/"
                            + arrTarefas[i].img+"' title='"+ arrTarefas[i].nome_user +"' alt='"+ arrTarefas[i].nome_user +"'/></div><div class='col-md-2 col-user-fat'><h2>Faturada em</h2> <br> "
                            +dataCompleta+"</div><div class='col-md-1 col-custof'><h2>Fornecedor</h2> <br> "
                            +valorFornecedorFinal+"</div><div class='col-md-1 col-custof'><h2>Cliente</h2> <br> "
                            +valorVendaFinal+"</div><div class='col-md-1 col-resultado'><h2>Resultado</h2> <br> "
                            +resultadoFinal+"</div><div class='col-md-1 col-vertarefa'><h2>Ver</h2><br><a href='listar_tarefa.php?id="
                            +arrTarefas[i].id_tarefa+"'><button class='btn main-btn btn-ir-tarefa'>Ir</button></a></div></div></div>"
                        );
                    

                }

                if(arrTarefas.length === 0){
                    $('#tarefas-container').empty().append('<h3 class="text-center">Sem dados. Tente outros filtros de pesquisa..</h3>');
                }

            }



            // AJAX Call para ir buscar todas as tarefas. No sucesso, chama a função definida mais em cima
            $.ajax({
                type:'POST',
                url:'ajax/listagem_ajax_faturadas.php',
                dataType: "json",
                success:function(data){
                    arrTarefasInteiro = data;
                    assignDataToArray();
                    console.log(arrTarefasInteiro)
                }
            });



            

            //Cada um destes blocos trata de cada um dos selects
            $('#filtro-cliente').change(function(){
                options.cliente = $(this).val();
                assignDataToArray();
            });

            $('#filtro-mes').change(function(){
                options.mes = $(this).val();
                assignDataToArray();
            });


    });

    </script>
</body>

</html>