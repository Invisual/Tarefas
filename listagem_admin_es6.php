<?php include('headers.php'); ?>
    <title>INVISUAL - Tarefas</title>
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
        position: fixed;
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

    @media screen and (max-width: 770px){

        .maincf {
            top: 15vh !important;
        }

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

        <h3 class="page-header"><i class="fa fa-tasks icons-header" title="Tarefas" aria-hidden="true"></i> &nbsp; Todas as <strong>Tarefas</strong></h3>

        <div class="contador" id="contadorhoras"></div>
        <div class="contador nodisplay" id="contadorhoras-highlighted"></div>

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

                    <select name="users" id="filtro-user">
                        <option value="" selected>Colaboradores</option>
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
                        <option value="">Estado</option>
                        <option value="0">Por Iniciar</option>
                        <option value="1">Em Curso</option>
                        <option value="2">Concluída</option>
                        <option value="3">Pausa</option>
                        <option value="4">Aguarda Aprovação Interna</option>
                        <option value="5">Aguarda Aprovação Externa</option>
                    </select>


                    <select name="tipotarefa" id="filtro-tipo-tarefa">
                        <option value="">Tipo de Tarefa</option>
                        <option value="0">Tarefa Normal</option>
                        <option value="1">Tarefa Diária</option>
                        <option value="2">Tarefa Externa</option>
                    </select>


                    <select name="modofaturacao" id="filtro-modo-faturacao">
                        <option value="">Modo Faturação</option>
                        <option value="0">Para Faturar</option>
                        <option value="1">Faturada</option>
                        <option value="2">Em Avença</option>
                        <option value="3">Em Análise</option>
                        <option value="4">Gratuita</option>
                    </select>

                </form>

                <button id="btn-processar-bulk">Concluir Tarefas</button>
            
            </div>

        </div>



        <div id="tarefas-container"></div>



    </div>

    <div class="modal-tarefa modal-tarefa-processada">
        <div class="close-modal">X</div>
        <form method="POST" action="processar_tarefa.php" class="form-processar-tarefa">
            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea name="observacoes" id="observacoes"></textarea>
            </div>
            <input type="hidden" name="idtarefa" id="modal-idtarefa" />
            <input type="hidden" name="valfaturada" id="modal-valfaturada"/>
            <input type="hidden" name="titulotarefa" id="modal-titulotarefa"/>
            <input type="hidden" name="user" value="<?php echo $iduser ?>"/>
            <input type="hidden" name="tipo" value="2"/>
            <div class="form-group">
                <button class="btn btn-primary">Concluir Tarefa</button>
            </div>
        </form>
    </div>

    <script>    
    $(document).ready(function(){

            //Definir todas as variáveis iniciais que vamos precisar
            var horastodastarefas = 0;
            var minutostodastarefas = 0;
            var arrTarefasInteiro;

            var options = {
                cliente: '',
                colaborador: '',
                estado: '',
                mes: '',
                tipo: '',
                modofaturacao: ''
            }


            //Definir Função que vai ser chamada no AJAX e vai ser chamada sempre que haja mudança num dos select
            function assignDataToArray(){

                //Inicialmente, limpamos todas as tarefas na DIV contentor
                $('#tarefas-container').empty();
                
                //Criamos uma nova variável que vai guardar o array que vem do AJAX, mas filtrado com os filtros desejados
                if(options.colaborador === ''){
                    arrTarefas = arrTarefasInteiro.tarefas.filter(tar => (
                        tar.id_cliente.includes(options.cliente) && tar.estado.includes(options.estado) && tar.tipo_tarefa.includes(options.tipo) && tar.faturada.includes(options.modofaturacao)
                    ));
                }
                else{
                    arrTarefas = arrTarefasInteiro.tarefas.filter(tar => (
                        tar.id_cliente.includes(options.cliente) && tar.intervenientes.indexOf(options.colaborador) != -1 && tar.estado.includes(options.estado) && tar.tipo_tarefa.includes(options.tipo) && tar.faturada.includes(options.modofaturacao)
                    ));
                }


                //Inicializar, fora do loop principal, as variáveis que vão contar todas as horas de todas as Tarefas
                var horasTodasTarefas = 0;
                var minutosTodasTarefas = 0;

                //Loop para percorrer este array filtrado
                for(var i = 0, count=arrTarefas.length; i<count; i++){

                    //Switch para dar nome em vez de valores ao campo 'faturada' de cada Tarefa e o mesmo para o 'estado'
                    switch(arrTarefas[i].faturada){
                        case '0':
                        faturadaName = 'Para Faturar';
                        break;

                        case '1':
                        faturadaName = 'Faturada';
                        break;

                        case '2':
                        faturadaName = 'Em Avença';
                        break;

                        case '3':
                        faturadaName = 'Em Análise';
                        break;

                        case '4':
                        faturadaName = 'Gratuita';
                        break;

                        default:
                        faturadaName = '-';
                        break;
                    }

                    var estadoName = '';
                    switch(arrTarefas[i].estado){
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

                    
                    //Criar variável onde vai ficar o HTML com a informação dos users destas tarefa, para depois ser injetado no append em baixo
                    var usersList = '';
                    for(var x = 0, contar=arrTarefas[i].intervenientes.length; x<contar; x++){
                            var utilizador = arrTarefasInteiro.users[arrTarefas[i].intervenientes[x]];
                            usersList += '<img class="user-img" src="img/users/'+ utilizador.img+'" title="'+ utilizador.nome +'" alt="'+ utilizador.nome +'"/>';
                    }


                    //Ir buscar as horas associadas a cada tarefa e fazer as contas necessárias para determinar o tempo total de cada tarefa.
                    //Por fim criamos a variável 'tempoTotal' que vai guardar o registo completo de tempo de cada tarefa.
                    var horasList = '';
                    var horasTotais = 0;
                    var minutosTotais = 0;
                    for(var y=0, contarY=arrTarefas[i].horas_tarefa.length; y<contarY; y++){

                        var hora = arrTarefasInteiro.horas[arrTarefas[i].horas_tarefa[y]];
                        
                        if(hora.dia.split('/')[1].includes(options.mes)){
                                        
                            var startTime=moment(hora.hora_inicio, "HH:mm a");
                            var endTime=moment(hora.hora_fim, "HH:mm a");
                            var duration = moment.duration(endTime.diff(startTime));
                            var hours = parseInt(duration.asHours());
                            var minutes = parseInt(duration.asMinutes())%60;
                            horasTotais += hours;
                            minutosTotais += minutes;
                            //horasList += '<span>'+hora.hora_inicio+' |</span>'
                        }

                    }
                    while(minutosTotais > 60){
                        horasTotais += 1;
                        minutosTotais -= 60;
                    }

                    if(isNaN(horasTotais)){
                        horasTotais = '-' ;
                    }
                    else{
                        horasTodasTarefas += horasTotais
                    }

                    if(isNaN(minutosTotais)){
                        minutosTotais = '-' ;
                    }
                    else{
                        minutosTodasTarefas += minutosTotais;
                        
                    }
                    var tempoTotal = horasTotais+'h:'+minutosTotais+'m';

                    var classCheck = 'fa-square';
                    arrTarefas[i].foi_faturada == 0 ? classCheck = 'fa-square' : classCheck = 'fa-check-square';


                        $('#tarefas-container').append(
                            "<div class='row row-tarefa-admin faturadatarefa-"+arrTarefas[i].faturada+" estado-"+arrTarefas[i].estado+" tipo-"+arrTarefas[i].tipo_tarefa+"' data-horas='"+horasTotais+"' data-minutos='"+minutosTotais+"' id='"
                            +arrTarefas[i].id_tarefa+"' data-faturacao='"+arrTarefas[i].faturada+"' data-titulo='"+arrTarefas[i].titulo+"'><div class='col-md-2 col-cliente'><h2>Cliente</h2> <br> "
                            +arrTarefas[i].nome+"</div><div class='col-md-2 col-titulo'><h2>Título</h2> <br> "
                            +arrTarefas[i].titulo+"</div><div class='col-md-1 col-desc'><h2>Descrição</h2> <br> "
                            +arrTarefas[i].descricao.substring(0, 60) + "..."+"</div><div class='col-md-1 col-estado'><h2>Estado</h2> <br>"
                            +estadoName+"</div><div class='col-md-1 col-faturacao'><h2>Faturação</h2> <br> <p>"
                            +faturadaName+"</p></div><div class='col-md-1 col-horas'><h2>Horas</h2><br>"
                            +tempoTotal+"</div><div class='col-md-2 col-intervenientes'><h2>Intervenientes</h2> <br>"
                            +usersList+"</div><div class='col-md-1 col-processartarefa'><h2>Concluir</h2><br><button onClick='return processarTarefa("
                            + arrTarefas[i].id_tarefa + "," + arrTarefas[i].faturada + ",\"" + arrTarefas[i].titulo + 
                            "\")' class='btn main-btn btn-processar-tarefa'>C</button></div><div class='col-md-1 col-vertarefa'><h2>Ver</h2><br><a href='listar_tarefa.php?id="
                            +arrTarefas[i].id_tarefa+"'><button class='btn main-btn btn-ir-tarefa'>Ir</button></a></div></div></div>"
                        );

                    
                    

                    

                }

                if(arrTarefas.length === 0){
                    $('#tarefas-container').empty().append('<h3 class="text-center">Sem dados. Tente outros filtros de pesquisa..</h3>');
                }
                
                while(minutosTodasTarefas > 60){
                    horasTodasTarefas += 1;
                    minutosTodasTarefas -= 60;
                }
                var tempoTotalTodasTarefas = horasTodasTarefas+'h:'+minutosTodasTarefas+'m';
                $('#contadorhoras').empty().append('<h3>'+tempoTotalTodasTarefas+'</h3>');

            }



            // AJAX Call para ir buscar todas as tarefas. No sucesso, chama a função definida mais em cima
            $.ajax({
                type:'POST',
                url:'ajax/listagem_ajax_admin_all.php',
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

            $('#filtro-user').change(function(){
                options.colaborador = $(this).val();
                assignDataToArray();
            });

            $('#filtro-estado').change(function(){
                options.estado = $(this).val();
                assignDataToArray();
            });

            $('#filtro-tipo-tarefa').change(function(){
                options.tipo = $(this).val();
                assignDataToArray();
            });

            $('#filtro-modo-faturacao').change(function(){
                options.modofaturacao = $(this).val();
                assignDataToArray();
            });


    });

    </script>



    <script>
    function processarTarefa(idtarefa, valfaturada, titulotarefa){
        
        if(valfaturada == 3){
            if(window.confirm("O modo de Faturação desta Tarefa está definido como 'Em Análise'. Tem a certeza que quer deixar assim?")){
                $.ajax({
                type: "GET",
                url: "./ajax/check_custos_tarefa.php",
                data: { 'id': idtarefa  },
                dataType: "json",
                success: function(data){
                    abrirModal(data);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('Algo correu mal! Tente de novo por favor.');
                }
            });
            }
        }
        else{
            $.ajax({
                type: "GET",
                url: "./ajax/check_custos_tarefa.php",
                data: { 'id': idtarefa  },
                dataType: "json",
                success: function(data){
                    abrirModal(data);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('Algo correu mal! Tente de novo por favor.');
                }
        });
        }


        function abrirModal(data){

            $('#modal-idtarefa').val(idtarefa);
            $('#modal-valfaturada').val(valfaturada);
            $('#modal-titulotarefa').val(titulotarefa);
            $('.modal-tarefa').addClass('mostrar-modal');

            if(data == 0){ 
                $('.alerta-modal').remove();
                $('.modal-tarefa form').append('<p class="alerta-modal">Esta Tarefa não tem nenhum Registo de Custos associado. Pode adicionar um <a target="_blank" href="insert_custos_tarefa.php?id='+idtarefa+'">aqui</a>.</p>');
            }
            else{
                $('.alerta-modal').remove();
            }

        }
    }

    $('.close-modal').on('click', function(){
        $('.modal-tarefa').removeClass('mostrar-modal');
    })


     //Script para somar as horas ao seleccionar varias tarefas
    $(document).on('click', '.row-tarefa-admin', function(){
        $(this).toggleClass('tarefa-single-highlight');
        var horasTodos = 0;
        var minutosTodos = 0;
        $('.tarefa-single-highlight').each(function(i, obj) {
            var horasTarefa = $(this).data('horas');
            var minutosTarefa = $(this).data('minutos');
            if(horasTarefa !== '-'){
                horasTodos += horasTarefa;
                minutosTodos += minutosTarefa;
                while(minutosTodos > 60){
                    horasTodos += 1;
                    minutosTodos -= 60;
                }
            }
        });
        var registoCompleto = horasTodos+'h:'+minutosTodos+'m';
        if(registoCompleto === '0h:0m'){
            $('#contadorhoras-highlighted').addClass('nodisplay').html('');
        }
        else{
            $('#contadorhoras-highlighted').removeClass('nodisplay').html('<h3>'+registoCompleto+'</h3>');
        }
    }).on('click', '.col-processartarefa, .col-vertarefa', function(e) {
        e.stopPropagation();
    });

    //Script para podermos Processar várias tarefas de uma vez
    $('#btn-select-bulk').click(function(){
        $('.tarefa-single-highlight').each(function(i, obj) {
            var id = $(this).attr('id');		
            var option = $('select[name=selectbulk]').val();
            var valFaturada = 0;
            if(option == 1){ valFaturada = 1 }
            else{ valFaturada = 0 }
            $.ajax({
                type: "GET",
                url: "./ajax/bulk-processadas.php",
                data: { 'id': id, 'option': option, 'faturada': valFaturada  },
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


  function faturarTarefa(tarefa, val){
      var newVal = 0;
      var valFaturada = 0;
      val == 0 ? newVal = 1 : newVal = 0;
      val == 0 ? valFaturada = 1 : valFaturada = 0;
      $.ajax({
            type:'GET',
            url:'./ajax/faturar-tarefa.php',
            data: { 'id': tarefa, 'val': newVal, 'faturada': valFaturada  },
            success: function(){4
                alert("Esta Tarefa foi actualizada como 'Faturada'!")
                location.reload()
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                alert('Algo correu mal! Tente de novo por favor.');
            }	
        });
  }


  $('#btn-processar-bulk').click(function(){
	$('.tarefa-single-highlight').each(function(i, obj) {
        var id = $(this).attr('id');	
        var faturacao = $(this).data('faturacao');
        var titulo = $(this).data('titulo');
        var user = <?php echo $iduser; ?>;
		$.ajax({
            type: "GET",
            url: "ajax/bulk-tarefas-concluidas.php",
            data: { 'id': id, 'faturacao': faturacao, 'titulo': titulo, 'user': user },
            success: function(){
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