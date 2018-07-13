<?php include('headers.php'); ?>

<title>INVISUAL - Mensagens</title>


<style>
    .btn-primary{
	background-color: #5093e1 !important;
        box-shadow: 0 3px 3px rgba(0,0,0,.3) !important;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	color:#fff !important;
	border:none !important;
    position:relative;
}

.btn-primary:hover{
    background-color: #5093e1 !important;
	box-shadow: 0 8px 3px rgba(0,0,0,.3) !important;
    top:-1px;
}

.row-list:hover{
    box-shadow: 0 1px 2px rgba(0,0,0,.1);
    top:0;
}

.msg-textarea{
  height: 50px !important;
}

</style>

<script language="JavaScript" type="text/javascript">
function checkMsg(){
    return confirm('Tem a certeza que quer enviar esta mensagem?');
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

// IR BUSCAR DADOS PARA LISTAR A TAREFA

$iduser = $_SESSION['id'];
$idnotificacao=$_GET['not'];
$idtarefa = $_GET['id'];
$titulo = $_GET['titulo'];
$cliente = $_GET['cliente'];

?>


<?php include('navbar.php'); ?>


<body>

<div class="container-fluid" style="position:relative; top:10vh;">
<h3 class="page-header"><i class="fa fa-comments icons-header" title="Mensagens" aria-hidden="true"></i></i> &nbsp;Mensagens de <strong><?php echo $titulo ?></strong> - <strong><?php echo $cliente ?></strong></h3>

<br>
<br>

<?php 
$ob = new classes_DbManager ();
$mensagens = $ob-> listarMensagens($idtarefa);
$notificacaoMensagemVista = $ob -> notificacaoMensagemVista($idnotificacao, $iduser);
$mensagensinfo = $mensagens->fetchAll(PDO::FETCH_ASSOC);

// Apagar registo deste user na tabela mensagem_vista desta tarefa para que se confirme que ele "viu"
$apagarVisto = $ob-> apagarVisto($idtarefa, $iduser);

//Seleccionar utilizador que NÃO ESTÃO na tabela mensagem_vista, ou seja, que já viram as mensagens desta tarefa
$usersVisto = $ob-> usersVisto($idtarefa);
?>

    <div class="fixed-div">

        <div class="vistos" <?php if(count($mensagensinfo) == 0){?> style="display:none;" <?php } ?>>

            <?php while($users= $usersVisto->fetch(PDO::FETCH_ASSOC)){ ?>

                <img src="img/users/<?php echo $users['img']; ?>" class="img-circle" width="28px" title="<?php echo $users['nome_user']; ?>">
                
            <?php } ?>
        
        </div>

        <!-- AO CLICAR NO BOTÃO, APARECE O FORM PARA SE INTRODUZIR NOVA MENSAGEM  -->
<div class="row" style="margin-top:10vh;">
    <div class="col-md-12" style="text-align:center; "><button class="btn btn-primary" id="showMsgsForm">Escrever Mensagem</button></div>
</div>

<br>
<br>

    <form action="" id="formMsgs" method="POST" hidden>
        <div class="row" style="width:80%; margin:0 auto;">
            <div class="col-md-10 offset-md-3"><textarea required style="border-radius: 15px !important;" id="msgtextarea" class="form-control msg-textarea" name="corpomsg" placeholder="Escreva a sua mensagem" rows="4"></textarea></div>

            <div class="col-md-1">
                <button type="submit" onclick="return checkMsg()" class="form-control btn btn-primary btn-plane" name="submit" value="Enviar" id="submit" style="height:30px !important; margin-top:9px !important;">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                </button>
            </div>

            <div class="col-md-1">
                <button type="button" class="form-control btn btn-primary btn-plane" name="users" id="btnusers" style="height:30px !important; margin-top:9px !important;">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </button>
            </div>

                <!--<input type="submit" class="form-control btn btn-primary" name="submit" value="Enviar" id="submit" style="height:31px !important; margin-top:4px !important;"></div> -->
        </div>
    </form>

    
    <div class="select-users" id="selectusers">
        <?php 
        $usersdata = $ob-> listarUsers();
        while($usersinfo = $usersdata->fetch(PDO::FETCH_ASSOC)){
            echo "<a href='#'><img src='img/users/".$usersinfo['img']."' class='img-circle img-select-user imgselectuser' width='28px' title='".$usersinfo['username']."'></a>";
        }
        ?>
    </div>


</div>

</div>

<?php 

if(count($mensagensinfo) == 0){
    echo "<h5 class='nocontent'>Esta tarefa não tem mensagens.</h5>";
}
else{
    foreach($mensagensinfo as $msgdata){ 
    $img = $msgdata['img'];
    //$idtask = $msgdata['id_task'];
    $newDate = date("H:i | d-m", strtotime($msgdata['data_msg']));
    ?>
    <div class="row row-list" style="margin:5vh auto; width:50%; border-radius:20px;">
       <div class="col-md-12">

            <p class="taskp"><?php echo $msgdata['corpo_msg']; ?></p>

            <h5 style="float:right; font-size:.9em; padding-top:20px;">por <strong><?php echo $msgdata['nome_user']; ?></strong>
            <img src="img/users/<?php echo $img?>" width="26px" class="img-circle"><br>
            <span>às <?php echo $newDate;?></span></h5>
            

        </div>
    </div>

<?php } } ?>


<script>

    $(document).ready(function(){

        $('#showMsgsForm').click(function(){
            $('#formMsgs').show();
            $('#showMsgsForm').hide();
        });

        $('#selectusers').hide();


        $('#btnusers').click(function(){
            $('#selectusers').show();
        });
        
        
        $('.imgselectuser').click(function(){
            var userTitle = $(this).attr('title');
            $('#msgtextarea').val($('#msgtextarea').val()+'@'+userTitle+' ');
        });
        
        



    });

</script>






<!-- POR FIM, INSERIR A NOVA MENSAGEM NA BASE DE DADOS  -->

<?php
    if(!empty($_POST)){

        $corpomsg = $_POST['corpomsg'];

        try{
            $log = new classes_UserManager($myControlPanel);
            $insert = $log->insertMensagem($corpomsg, $iduser, $idtarefa);
            $myDb = new classes_DbManager;
            $queryUsers = $myDb->_myDb->prepare("Select * from users");
		    $queryUsers->execute();
            while($row = $queryUsers->fetch(PDO::FETCH_ASSOC))
                {
                    $mensagemVista = $log->mensagemVista($idtarefa, $row['id_user']);
                }


        }
        catch (invalidArgumentException $e){

            $e->getMessage();
        }
	
    }




?>

</body>
</html>