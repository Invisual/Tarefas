<?php

class classes_UserManager {

	private $_controlPanel;
	public function __construct($controlPanel) {

		if (!is_a($controlPanel,'classes_ControlPanel')){

			throw new InvalidArgumentException('Invalid Arguments');
		}
		$this->_controlPanel = $controlPanel;
	}


	public function insertUser($username, $nome, $password, $img){
        
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query =$myDb->prepare("INSERT INTO users (username, password, nome_user, img, admin) VALUES (:username, :password, :nome_user, :img, :admin)");
		$query->bindParam(':username', $user);
		$query->bindParam(':password', $pass);
		$query->bindParam(':nome_user', $name);
		$query->bindParam(':img', $imagem);
		$query->bindParam(':admin', $admin);

		$user = $myDbGet->purificar($username);
		$pass = $myDbGet->purificar($password);
		$name = $myDbGet->purificar($nome);
		$imagem = $myDbGet->purificar($username);
		$admin = 0;

		$query->execute();
		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Novo Utilizador Adicionado!');
				window.location.href = 'index.php';
			</script>
			";
		}

	}
	
	
	public function login($username, $password){

		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$password = md5($password);
		$query = $myDb->prepare("Select * FROM users WHERE username = :username and password = :password");

			$query->bindParam(':username', $usern);
			$query->bindParam(':password', $pass);

			$usern = $myDbGet->purificar($username);
			$pass = $myDbGet->purificar($password);
			$query->execute();
			$row_cnt = $query->rowCount();
			
			if ($row_cnt==1){
				$row = $query->fetch(PDO::FETCH_ASSOC);
				$_SESSION['name']=$row['nome_user'];
				$_SESSION["id"]=$row['id_user'];
				$_SESSION["logged_in"] = 1;
				$_SESSION["admin"] = $row['admin'];
				$_SESSION["superadmin"] = $row['superadmin'];
				$_SESSION["img"] = $row['img'];
				
				echo "
			<script type='text/javascript'>
				window.alert('Bem-vindo ".$row['nome_user']."!');
				window.location.href = 'index.php';
			</script>
			";
			}
			
			else {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				window.location.href = 'login.php';
			</script>
			";
			}
		
		
	}
	
	public function logout(){
        unset($_SESSION['name']);
		unset($_SESSION['image']);
		unset($_SESSION['id']);
        unset($_SESSION['logged_in']);
        session_destroy();
		
	}
	
	
	
	public function insertTarefa($titulo, $descricao, $cliente, $datafim, $intervenientes, $diaria, $avenca){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("INSERT INTO tarefas (titulo, descricao, cliente_id, data_ini, data_fim, estado, prioridade_id, urgente, diaria, avenca) VALUES (:titulo, :descricao, :cliente, :dataini, :datafim, :estado, :prioridade, :urgente, :diaria, :avenca)");

		$query->bindParam(':titulo', $title);
		$query->bindParam(':descricao', $desc);
		$query->bindParam(':cliente', $client);
		$query->bindParam(':dataini', $datain);
		$query->bindParam(':datafim', $datafi);
		$query->bindParam(':estado', $estado);
		$query->bindParam(':prioridade', $prioridade);
		$query->bindParam(':diaria', $diaria);
		$query->bindParam(':avenca', $avenca);
		$query->bindParam(':urgente', $urgente);
		
		$title = $myDbGet->purificar($titulo);
		$desc = $myDbGet->purificar($descricao);
		$client = $myDbGet->purificar($cliente);
		$diaria = $myDbGet->purificar($diaria);
		$avenca = $myDbGet->purificar($avenca);
		$prioridade = 1;
		$datain = '0000-00-00';
		$datafi = $myDbGet->purificar($datafim);
		$estado = 0;
		$urgente = 0;
		$query->execute();
		$idtarefa = $myDb -> lastInsertId();


		$queryinterv = $myDb->prepare("INSERT INTO intervenientes_tarefa (tarefa_interv_id, user_interv_id) VALUES (:tarefa, :user)");
		$queryordem = $myDb->prepare("INSERT INTO ordem (id_tarefa_ordem, id_user_ordem, valor_ordem) VALUES (:tar, :utilizador, :valor)");

		for($x=0; $x < count($intervenientes); $x++)
		{
			$queryinterv->bindParam(':tarefa', $tarefa);
			$queryinterv->bindParam(':user', $user);

			$tarefa = $idtarefa;
			$user = $myDbGet->purificar($intervenientes[$x]);
			$queryinterv -> execute();
			$notificacao = $this->criarNotificacao($intervenientes[$x], $idtarefa);

			$queryordem->bindParam(':tar', $tar);
			$queryordem->bindParam(':utilizador', $utilizador);
			$queryordem->bindParam(':valor', $valor);

			$tar = $idtarefa;
			$utilizador = $myDbGet->purificar($intervenientes[$x]);
			$valor = 'A definir';
			$queryordem -> execute();
		}


		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Nova Tarefa Adicionada!');
				window.location.href = 'list_tarefas.php';
			</script>
			";
		}
			
	}
	
	
	
	public function insertTarefaDiaria($titulo, $descricao, $cliente, $user){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("INSERT INTO tarefas_diarias (titulo_tar_diaria, desc_tar_diaria, user_tar_diaria, cliente_tar_diaria, estado_tar_diaria) VALUES (:titulo, :descricao, :user, :cliente, :estado)");

		$query->bindParam(':titulo', $titulo);
		$query->bindParam(':descricao', $descricao);
		$query->bindParam(':user', $user);
		$query->bindParam(':cliente', $cliente);
		$query->bindParam(':estado', $estado);
		
		$titulo = $myDbGet->purificar($titulo);
		$descricao = $myDbGet->purificar($descricao);
		$user = $myDbGet->purificar($user);
		$cliente = $myDbGet->purificar($cliente);
		$estado = 0;
		$urgente = 0;
		$query->execute();


		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Nova Tarefa Diária Adicionada!');
				window.location.href = 'list_tarefas_diarias.php';
			</script>
			";
		}
			
	}




    public function insertObservacao($userobs, $tarefaobs, $textoobs){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("INSERT INTO observacoes (id_tarefa_observacao, id_user_observacao, texto) VALUES (:tarefaobs, :userobs, :textoobs)");

		$query->bindParam(':userobs', $userobs);
		$query->bindParam(':tarefaobs', $tarefaobs);
		$query->bindParam(':textoobs', $textoobs);
		
		$textoobs = $myDbGet->purificar($textoobs);
		$tarefaobs = $tarefaobs;
		$userobs = $userobs;
		$query->execute();


		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
			window.alert('A observação foi adicionada !');
			window.location.href = 'listar_tarefa.php?id=".$tarefaobs."';
			</script>
			";
		}
			
	}






	public function updateTarefa($titulo, $descricao, $cliente, $dataini, $datafim, $urgente, $estado, $intervenientes, $idtarefa, $tarefadiaria, $avencatarefa){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("UPDATE tarefas set titulo = :titulo, descricao = :descricao, cliente_id = :cliente, data_ini = :dataini, data_fim = :datafim, estado = :estado, prioridade_id = :prioridade, urgente = :urgente, diaria = :tarefadiaria, avenca = :avencatarefa WHERE id_tarefa = :idtarefa");

		$query->bindParam(':titulo', $titulo);
		$query->bindParam(':descricao', $descricao);
		$query->bindParam(':cliente', $cliente);
		$query->bindParam(':dataini', $dataini);
		$query->bindParam(':datafim', $datafim);
		$query->bindParam(':estado', $estado);
		$query->bindParam(':prioridade', $prioridade);
		$query->bindParam(':urgente', $urgente);
		$query->bindParam(':tarefadiaria', $tarefadiaria);
		$query->bindParam(':avencatarefa', $avencatarefa);
		$query->bindParam(':idtarefa', $idtarefa);

		$titulo = $myDbGet->purificar($titulo);
		$descricao = $myDbGet->purificar($descricao);
		$clinte = $myDbGet->purificar($cliente);
		$dataini = $myDbGet->purificar($dataini);
		$datafim = $myDbGet->purificar($datafim);
		$estado = $myDbGet->purificar($estado);
		$prioridade = 1;
		$urgente = $myDbGet->purificar($urgente);
		$tarefadiaria = $myDbGet->purificar($tarefadiaria);
		$avencatarefa = $myDbGet->purificar($avencatarefa);
		$idtarefa = $idtarefa;
		$query->execute();


		$deleteinterv = $myDb->prepare("DELETE FROM intervenientes_tarefa WHERE tarefa_interv_id = :tarefa");
		$deleteinterv->bindParam(':tarefa', $idtarefa);
		$idtarefa = $idtarefa;
		$deleteinterv -> execute();

		$deleteintervordem = $myDb->prepare("DELETE FROM ordem WHERE id_tarefa_ordem = :tarefa");
		$deleteintervordem->bindParam(':tarefa', $idtarefa);
		$idtarefa = $idtarefa;
		$deleteintervordem -> execute();


		$queryinterv = $myDb->prepare("INSERT INTO intervenientes_tarefa (tarefa_interv_id, user_interv_id) VALUES (:tarefa, :user)");
		$queryordem = $myDb->prepare("INSERT INTO ordem (id_tarefa_ordem, id_user_ordem, valor_ordem) VALUES (:tar, :utilizador, :valor)");
		for($x=0; $x < count($intervenientes); $x++)
		{	

			$queryinterv->bindParam(':tarefa', $idtarefa);
			$queryinterv->bindParam(':user', $user);

			$idtarefa = $idtarefa;
			$user = $myDbGet->purificar($intervenientes[$x]);
			$queryinterv -> execute();


			$queryordem->bindParam(':tar', $tar);
			$queryordem->bindParam(':utilizador', $utilizador);
			$queryordem->bindParam(':valor', $valor);

			$tar = $idtarefa;
			$utilizador = $myDbGet->purificar($intervenientes[$x]);
			$valor = 'A definir';
			$queryordem -> execute();
		}


		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('A Tarefa foi editada!');
				window.location.href = 'list_tarefas.php';
			</script>
			";
		}
			
	}
	
	
	
	public function updateHoras($hora_inicio, $hora_fim, $dia, $idhora, $idtarefa){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("UPDATE horas set hora_inicio = :hora_inicio, hora_fim = :hora_fim, dia = :dia WHERE id_hora = :idhora");

		$query->bindParam(':hora_inicio', $hora_inicio);
		$query->bindParam(':hora_fim', $hora_fim);
		$query->bindParam(':idhora', $idhora);
		$query->bindParam(':dia', $dia);

		$hora_inicio = $myDbGet->purificar($hora_inicio);
		$hora_fim = $myDbGet->purificar($hora_fim);
		$dia = $myDbGet->purificar($dia);
		$idhora = $idhora;
		$idtarefa = $idtarefa;
		$query->execute();

		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Este registo de horas foi editado!');
				window.location.href = 'listar_tarefa.php?id=".$idtarefa."';
			</script>
			";
		}
			
	}
	
	
	public function updateObservacao($idobs, $texto, $idtarefa){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("UPDATE observacoes set texto = :texto WHERE id_observacao = :idobs");

		$query->bindParam(':texto', $texto);
		$query->bindParam(':idobs', $idobs);

		$texto = $myDbGet->purificar($texto);
		$idobs = $idobs;
		$query->execute();

		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Esta observação foi editada!');
				window.location.href = 'listar_tarefa.php?id=".$idtarefa."';
			</script>
			";
		}
			
	}
	
	
		public function updateTarefaDiaria($titulo, $descricao, $cliente, $user, $estado, $idtarefa){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("UPDATE tarefas_diarias set titulo_tar_diaria = :titulo, desc_tar_diaria = :descricao, cliente_tar_diaria= :cliente, user_tar_diaria = :user, estado_tar_diaria = :estado WHERE id_tar_diaria = :idtarefa");

		$query->bindParam(':titulo', $titulo);
		$query->bindParam(':descricao', $descricao);
		$query->bindParam(':cliente', $cliente);
		$query->bindParam(':user', $user);
		$query->bindParam(':estado', $estado);
		$query->bindParam(':idtarefa', $idtarefa);

		$titulo = $myDbGet->purificar($titulo);
		$descricao = $myDbGet->purificar($descricao);
		$clinte = $myDbGet->purificar($cliente);
		$estado = $myDbGet->purificar($estado);
		$user = $myDbGet->purificar($user);
		$idtarefa = $idtarefa;
		$query->execute();


		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('A Tarefa Diária foi editada!');
				window.location.href = 'list_tarefas_diarias.php';
			</script>
			";
		}
			
	}



	public function insertCliente($nome){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("INSERT INTO clientes (nome) VALUES (:nome)");

		$query->bindParam(':nome', $nome);

		$nome = $myDbGet->purificar($nome);
		$query->execute();
		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Novo Cliente Adicionado - ". $nome ." .');
				window.location.href = 'list_clientes.php';
			</script>
			";
		}
			
	}




	public function insertTask($desctask, $useridtask, $tarefaidtask){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("INSERT INTO tasks (descricao_task, user_id_task, tarefa_id_task, concluido_task, prioridade_task) VALUES (:desctask, :useridtask, :tarefaidtask, :concluido_task, :prioridade_task)");

		$query->bindParam(":desctask", $desctask);
		$query->bindParam(":useridtask", $useridtask);
		$query->bindParam(":tarefaidtask", $tarefaidtask);
		$query->bindParam(":concluido_task", $conctask);
		$query->bindParam(":prioridade_task", $prioridadetask);

		$desctask = $myDbGet->purificar($desctask);
		$useridtask = $myDbGet->purificar($useridtask);
		$tarefaidtask = $myDbGet->purificar($tarefaidtask);
		$conctask = '0';
		$prioridadetask = '1';
		$query->execute();
		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Nova Tarefa adicionada.');
				window.location.href = 'listar_tarefa.php?id=". $tarefaidtask ."';
			</script>
			";
		}
			
	}


	public function insertMensagem($corpomsg, $iduser, $idtarefa){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("INSERT INTO mensagens (user_id_msg, corpo_msg, tarefa_id_msg) VALUES (:iduser, :corpomsg, :idtarefa)");

		$query->bindParam(":iduser", $iduser);
		$query->bindParam(":corpomsg", $corpomsg);
		$query->bindParam(":idtarefa", $idtarefa);

		$iduser = $myDbGet->purificar($iduser);
		$corpomsg = $myDbGet->purificar($corpomsg);
		$idtarefa = $myDbGet->purificar($idtarefa);
    
        
		$query->execute();
		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
		    preg_replace_callback('/\@([a-zA-Z0-9]+)/',function($partes) use($idtarefa){$this->notificacaoMensagem($partes[1], $idtarefa);}, $corpomsg);
			echo "
			<script type='text/javascript'>
				window.alert('A sua Mensagem foi Enviada.');
				window.location.href = 'listar_tarefa.php?id=". $idtarefa ."';
			</script>
			";
		}
			
	}
	
	
	public function notificacaoMensagem($partes, $idtarefa){
	    
	   	$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("SELECT id_user from users where username = :partes");
		
		$query->bindParam(":partes", $partes);
		$partes = $partes;
		$query->execute();
		
		$iduser = $query->fetchColumn();
		$insertnotificacao = $myDb->prepare("INSERT INTO notificacoes_mensagens (tarefa_not_msg, user_not_msg, aberta_not_msg) VALUES (:idtarefa, :iduser, :aberta)");
		$insertnotificacao->bindParam(":idtarefa", $idtarefa);
		$insertnotificacao->bindParam(":iduser", $iduser);
		$insertnotificacao->bindParam(":aberta", $aberta);
		
		$idtarefa = $idtarefa;
		$iduser = $iduser;
		$aberta = 0;
		
	    $insertnotificacao->execute();
	    
	}

	public function mensagemVista($idtarefa, $iduser){

			$myDb = $this->_controlPanel->getMyDb();
			$query = $myDb->prepare("INSERT INTO mensagem_vista (tarefa_vista_id, user_vista_id) VALUES (:idtarefa, :iduser)");

			$query->bindParam(":idtarefa", $idtarefa);
			$query->bindParam(":iduser", $iduser);

			$idtarefa = $idtarefa;
			$iduser = $iduser;
			$query->execute();

	}



	public function updateEstado($idtarefa, $val){
		
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("UPDATE tarefas SET estado = :val WHERE id_tarefa = :idtarefa ");

		$query->bindParam(":val", $val);
		$query->bindParam(":idtarefa", $idtarefa);

		$val = $val;
		$idtarefa = $idtarefa;
		$query->execute();
		if (!$query) {
			header( "Refresh:3; url=index.php");
		}
		else {
			header('Location: '.$_SERVER['PHP_SELF']);  
		}
			
	}
	
	
	public function updateEstadoTarefa($idtarefa, $val){
		
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("UPDATE tarefas SET estado = :val WHERE id_tarefa = :idtarefa ");

		$query->bindParam(":val", $val);
		$query->bindParam(":idtarefa", $idtarefa);

		$val = $val;
		$idtarefa = $idtarefa;
		$query->execute();
		if (!$query) {
			header( "Refresh:3; url=index.php");
		}
			
	}
	
	
	
	public function updateFaturacaoTarefa($idtarefa, $valfaturacao){
		
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("UPDATE tarefas SET faturada = :valfaturacao WHERE id_tarefa = :idtarefa ");

		$query->bindParam(":valfaturacao", $valfaturacao);
		$query->bindParam(":idtarefa", $idtarefa);

		$valfaturacao = $valfaturacao;
		$idtarefa = $idtarefa;
		$query->execute();
		if (!$query) {
			header( "Refresh:3; url=index.php");
		}
			
	}



	public function updateOrdemTarefa($idtarefa, $iduser, $val){
		
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("UPDATE ordem SET valor_ordem = :val WHERE id_tarefa_ordem = :idtarefa AND id_user_ordem = :iduser  ");
		var_dump($idtarefa, $iduser);
		$query->bindParam(":val", $val);
		$query->bindParam(":idtarefa", $idtarefa);
		$query->bindParam(":iduser", $iduser);

		$val = $val;
		$idtarefa = $idtarefa;
		$iduser = $iduser;
		$query->execute();
		if (!$query) {
			header( "Refresh:3; url=index.php");
		}
			
	}
	
	
	
	public function updateEstadoDiaria($idtarefa, $val){
		
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("UPDATE tarefas_diarias SET estado_tar_diaria = :val WHERE id_tar_diaria = :idtarefa ");

		$query->bindParam(":val", $val);
		$query->bindParam(":idtarefa", $idtarefa);

		$val = $val;
		$idtarefa = $idtarefa;
		$query->execute();
		if (!$query) {
			header( "Refresh:3; url=index.php");
		}
			
	}




	public function updateConcluidoTask($idtask, $val){
	
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("UPDATE tasks SET concluido_task = :val WHERE id_task = :idtask ");

		$query->bindParam(":val", $val);
		$query->bindParam(":idtask", $idtask);

		$val = $val;
		$idtask = $idtask;

		$query->execute();
		
	}



	public function criarNotificacao($interveniente, $idtarefa){
		
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("INSERT INTO notificacoes (aberta, not_tarefa_id, not_user_id) VALUES ( :aberta, :idtarefa, :interveniente)");

		$query->bindParam(":aberta", $aberta);
		$query->bindParam(":idtarefa", $idtarefa);
		$query->bindParam(":interveniente", $interveniente);

		$aberta = 0;
		$idtarefa = $idtarefa;
		$interveniente = $interveniente;

		$query->execute();
			
	}

		
		public function searchUserTasks($search){
		
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$query = $myDb->prepare("SELECT * FROM tarefas INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN intervenientes_tarefa ON tarefas.id_tarefa = intervenientes_tarefa.tarefa_interv_id INNER JOIN users on intervenientes_tarefa.user_interv_id = users.id_user WHERE ( processada = 0 and nome like :search ) group by id_tarefa ORDER BY data_fim asc ");
		$query->bindParam(":search", $search);
		$search = '%'.$myDbGet->purificar($search).'%';
		$query->execute();
		return ($query);
		
			
	}


	public function getUserIdByName($search){
		$myDb = $this->_controlPanel->getMyDb();
		$myDbGet = $this->_controlPanel->get();
		$userid = $myDb->prepare("SELECT id_user from users WHERE nome_user LIKE :search LIMIT 1 ");
		$userid->bindParam(":search", $search);
		$search = '%'.$myDbGet->purificar($search).'%';
		$userid->execute();
		while($dados=$userid->fetch(PDO::FETCH_ASSOC)){
			$iduser = $dados['id_user'];
		}
		return $iduser;
	}



	public function updateTask($descricao, $colaborador, $prioridade, $idtask){
		
		$myDb = $this->_controlPanel->getMyDb();
		$query = $myDb->prepare("UPDATE tasks set descricao_task = :descricao, user_id_task = :colaborador, prioridade_task = :prioridade WHERE id_task = :idtask ");

		$query->bindParam(":descricao", $descricao);
		$query->bindParam(":colaborador", $colaborador);
		$query->bindParam(":prioridade", $prioridade);
		$query->bindParam(":idtask", $idtask);

		$descricao = $descricao;
		$colaborador = $colaborador;
		$prioridade = $prioridade;
		$idtask = $idtask;
		$query->execute();
		
		if (!$query) {
				echo "
			<script type='text/javascript'>
				window.alert('Algo correu mal, tente de novo.');
				location.reload();
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				window.alert('Esta Tarefa foi editada!');
				window.location.href = 'index.php';
			</script>
			";
		}
			
	}


}
?>