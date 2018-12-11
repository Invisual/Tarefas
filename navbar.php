<?php 
$iduser=$_SESSION['id'];
$image=$_SESSION['img'];
$nome = $_SESSION['name'];
$logged = $_SESSION["logged_in"];
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

include('notificacoes.php');
 ?>

<style>
  ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    font-size:.9em;
  }
  ::-moz-placeholder { /* Firefox 19+ */
    font-size:.9em;
  }
  :-ms-input-placeholder { /* IE 10+ */
    font-size:.9em;
  }
  :-moz-placeholder { /* Firefox 18- */
    font-size:.9em;
  }

</style>

<nav class="navbar navbar-inverse navbar-fixed-top">

  <div class="container-fluid">

    <div class="navbar-header" style="margin-top: 7px;">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>

      <a class="navbar-brand" href="index.php"><img src="img/logonew1.png" width="156px" class="img-responsive"></a>

    </div>

    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav" style="margin-top: 9px;">

      <li><a href="index.php"><i class="fa fa-home icons-menu" title="Home" aria-hidden="true"></i></a></li>


       <?php if($_SESSION['admin']==1){ ?>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="icons-menu" title="Administração" style="font-weight:700;">A</span>
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="listagem_admin.php">Todas as Tarefas</a></li>
            <li><a href="list_tarefas_faturadas.php">Tarefas Faturadas</a></li>
            <li><a href="list_clientes_avencados.php">Bolsas de Horas por Cliente</a></li>
          </ul>
        </li>
      <?php } ?>

      <?php if($_SESSION['admin']==1){ ?>
      <li class="dropdown">
          <a href="list_tarefas_processadas.php">
            <span class="icons-menu" title="Tarefas Concluídas" style="font-weight:700;">C</span>
          </a>
      </li>
      <?php } ?>

      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
         <i class="fa fa-tasks icons-menu" title="Tarefas" aria-hidden="true"></i>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="list_tarefas.php">Ver Todas Tarefas</a></li>
          <li><a href="list_my_tarefas.php">As Minhas Tarefas</a></li>
          <li><a href="insert_tarefa.php">Inserir Tarefa</a></li>
        </ul>
      </li>
      
     

      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="fa fa-users icons-menu" title="Clientes" aria-hidden="true"></i>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="list_clientes.php">Ver Clientes</a></li>
          <?php if($_SESSION['admin'] == 1){ ?>
          <li><a href="insert_cliente.php">Adicionar Cliente</a></li>
          <?php } ?>
          <li><a href="insert_info_cliente.php">Adicionar Info de Cliente</a></li>
        </ul>
      </li>



      <?php if($_SESSION['superadmin']==1){ ?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          <span class="icons-menu" title="Tarefas para Processar" style="font-weight:700;">H</span>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="listar_horas_users.php">Horas de Utilizadores</a></li>
        </ul>
      </li>
      <?php } ?>

      </ul>
    

      <form class="navbar-form navbar-left" action="tarefas_pesquisa.php" method="POST" style="margin-top: 16px;">
      <div class="form-group">
        <input type="text" name="search" id="search" class="searchform" placeholder="&nbsp;Pesquisar Clientes">
      </div>
      <button type="submit" class="btn btn-search"><i class="fa fa-search icons-menu" title="Pesquisar" aria-hidden="true"></i></button>
    </form>
   

      <ul class="nav navbar-nav navbar-right">
          


            <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><div class="notificacoes"><i style="font-size:1.6em;" class="fa fa-clock-o icon-notificacoes" aria-hidden="true"></i><?php if($countNotificacoesHoras != 0){?><p style="margin-top:-8px;"><?php echo $countNotificacoesHoras;?></p><?php } ?></div></a>
            <ul class="dropdown-menu">
              <?php
              if($countNotificacoesHoras != 0){
              $getNotificacoesHoras= $count->getNotificacoesHoras($iduser); 
              while($notifhoras = $getNotificacoesHoras->fetch(PDO::FETCH_ASSOC)){ 
              ?>
                  <li>
                    <a href="listar_tarefa.php?id=<?php echo $notifhoras['tarefa_id']; ?>">
                        Tem um registo de Horas aberto em - <strong><?php echo $notifhoras['titulo']; ?></strong>
                    </a>
                  </li>
                <?php } } else{?>
                  <li style="padding: 5px 10px 5px 10px;font-size: 13px;"><span>Sem registos de Horas abertos</span></li>
               <?php } ?>
            </ul>
          </li>
    

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><div class="notificacoes"><i style="font-size:1.3em;margin-top:2px;" class="fa fa-bell icon-notificacoes" aria-hidden="true"></i><?php if($countNotificacoes != 0){?><p style="margin-top:-8px;"><?php echo $countNotificacoes;?></p><?php } ?></div></a>
            <ul class="dropdown-menu">
              <?php
              $getNotificacoes= $count->getNotificacoes($iduser); 
               while($notif = $getNotificacoes->fetch(PDO::FETCH_ASSOC)){ 
              ?>
                  <li <?php if($notif['aberta'] == 0){?>style="background-color:#e6e5e5 !important;"<?php } ?>>
                    <a href="listar_tarefa.php?id=<?php echo $notif['id_tarefa']; ?>&titulo=<?php echo $notif['titulo']; ?>&not=<?php echo $notif['id_not']; ?>">
                        Tem uma nova Tarefa - <strong><?php echo $notif['titulo']; ?></strong>
                    </a>
                  </li>
               <?php } ?>
               <li style="margin-top:15px;"><a href="limpar_notificacoes.php?id=<?php echo $_SESSION["id"] ?>&link=<?php echo $actual_link; ?>">Limpar tudo &nbsp; <i class="fa fa-times"></i></a></li>
            </ul>
          </li>


          <li class="dropdown">
            <a href="regulamento.php" style="margin-top: 8px;">
              <span class="icons-menu" title="Regulamento" style="font-weight:700;">R</span>
            </a>
          </li>
          
      
 
		<?php if ($logged == 0){ ?>
      <li><a href="login.php"><i class="fa fa-sign-in icons-menu" aria-hidden="true"></i>Login</a></li>
	  <?php }
	  else{
	  ?>

	  <li>
				<a href="#">
					<?php echo $nome ?> &nbsp; 
					<img src="img/users/<?php echo $image ?>" style="border-radius:50%;" width="35px" height="35px">
				</a>
		</li>

		<li style="margin-top:8px;"><a href="logout.php"><i class="fa fa-sign-out icons-menu" aria-hidden="true"></i></a></li>
	  <?php } ?>

    </ul>

    </div>

  </div>

</nav>