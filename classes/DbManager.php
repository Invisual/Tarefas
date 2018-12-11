<?php

class classes_DbManager{

	//private $_username = "pg22933";
	private $_username = "root";
	//private $_password = "16dbEDCFJd";
	private $_password = "";
	private $_host = "localhost";
	//private $_dbName = "pg22933_tarefas";
	private $_dbName = "tarefas";
	public $_myDb;
	private static $_objecto = false;
	private $_purifier;

	public function __construct(){
		//error_reporting(E_ALL); ini_set('display_errors','On');
		error_reporting(0);

		require_once 'library/HTMLPurifier.auto.php';

		$config = HTMLPurifier_Config::createDefault();
		$this->_purifier = new HTMLPurifier($config);


		//$this->_myDb=new mysqli($this->_host, $this->_username, $this->_password, $this->_dbName);

		try{$this->_myDb = new PDO("mysql:host=$this->_host;dbname=$this->_dbName;charset=utf8", $this->_username, $this->_password);
    // set the PDO error mode to exception
    	$this->_myDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		catch(exception $e){
			var_dump($e);
		}


		//if(mysqli_connect_error()){
		//	throw new Exception('Database Fatal Error');
		//}
	}


	public function purificar($dirty_html){

		return $this->_purifier->purify($dirty_html);

	}


	public static function ob(){
		if(self::$_objecto == false){
			self::$_objecto = new self();
		}

		return self::$_objecto;
	}


	public function performQuery($query){

		$result = null;
		$result = $this->_myDb->query($query);

		if(!$result){
			return("Query Error");
		}

		else{
			return($result);
		}
	}


	public function closeConnection(){
		$this->_myDb->close();
	}


		 
		 
		 public function listTarefa ($idtarefa){
		 
			$query = $this->_myDb->prepare("SELECT *  FROM tarefas INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tarefas.prioridade_id=prioridade.id_prioridade WHERE id_tarefa = :idtarefa ") ; 

			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa =$idtarefa;
			$query -> execute();
			return ($query);
		 
		 }
		 
		 
		 public function listInfoCliente ($idcliente){
		 
			$query = $this->_myDb->prepare("SELECT *  FROM infos_clientes INNER JOIN clientes ON infos_clientes.cliente_id=clientes.id_cliente WHERE cliente_id = :idcliente ") ; 

			$query->bindParam(":idcliente", $idcliente);
			$idcliente =$idcliente;
			$query -> execute();
			return ($query);
		 
		 }
		 
		 
		 public function listInfoClienteById($idinfo){
		 
			$query = $this->_myDb->prepare("SELECT *  FROM infos_clientes INNER JOIN clientes ON infos_clientes.cliente_id=clientes.id_cliente WHERE id_info = :idinfo ") ; 

			$query->bindParam(":idinfo", $idinfo);
			$idinfo =$idinfo;
			$query -> execute();
			return ($query);
		 
		 }
		 
		 
		 
		 public function listHora($idhora){
			
			   $query = $this->_myDb->prepare("SELECT *  FROM horas INNER JOIN users ON horas.user_id=users.id_user INNER JOIN tarefas ON horas.tarefa_id=tarefas.id_tarefa WHERE id_hora = :idhora ") ; 
   
			   $query->bindParam(":idhora", $idhora);
			   $idhora =$idhora;
			   $query -> execute();
			   return ($query);
			
			}
			
			
		public function listObservacao($idobs){
				
				$query = $this->_myDb->prepare("SELECT *  FROM observacoes WHERE id_observacao = :idobs ") ; 
	   
				$query->bindParam(":idobs", $idobs);
				$idobs =$idobs;
				$query -> execute();
				return ($query);
				
			}
		 
		 
		 public function listTarefaDiaria ($idtarefa){
		 
			$query = $this->_myDb->prepare("SELECT * FROM tarefas_diarias INNER JOIN clientes ON tarefas_diarias.cliente_tar_diaria=clientes.id_cliente INNER JOIN users ON tarefas_diarias.user_tar_diaria=users.id_user WHERE id_tar_diaria = :idtarefa ") ; 

			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa =$idtarefa;
			$query -> execute();
			return ($query);
		 
		 }
		 

		
		 public function listarTarefas ($idcliente){
		 
			if($idcliente == 0){
				$query = $this->_myDb->prepare("SELECT * FROM tarefas INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tarefas.prioridade_id=prioridade.id_prioridade where processada = 0 order by urgente desc, data_fim asc ");
			}
			else{
				$query = $this->_myDb->prepare("SELECT * FROM tarefas INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tarefas.prioridade_id=prioridade.id_prioridade where cliente_id = :idcliente and processada = 0 order by urgente desc, data_fim asc ");
				$query->bindParam(":idcliente", $idcliente);
				$idcliente = $idcliente;
			}
			$query -> execute();
			return ($query);
		 
		 }
		 
		 
		 
		 public function listarObservacoes($idtarefa){
			

				$query = $this->_myDb->prepare("SELECT * FROM observacoes INNER JOIN users on observacoes.id_user_observacao = users.id_user WHERE id_tarefa_observacao = :idtarefa ");
				$query->bindParam(":idtarefa", $idtarefa);
				$idtarefa = $idtarefa;
			    $query -> execute();
			    return ($query);
			
			}
		 
		 


		  public function listarTarefasUser($idutilizador){
			
			$query = $this->_myDb->prepare("SELECT * FROM tarefas INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tarefas.prioridade_id = prioridade.id_prioridade INNER JOIN intervenientes_tarefa ON tarefas.id_tarefa = intervenientes_tarefa.tarefa_interv_id INNER JOIN users on intervenientes_tarefa.user_interv_id = users.id_user INNER JOIN ordem on tarefas.id_tarefa = ordem.id_tarefa_ordem WHERE id_user = :idutilizador AND id_user_ordem = :idutilizador and processada = 0 GROUP BY id_tarefa ORDER BY tipo_tarefa desc, CHAR_LENGTH(valor_ordem), valor_ordem asc");
			$query->bindParam(":idutilizador", $idutilizador);
			$idutilizador = $idutilizador;
			$query -> execute();
			return ($query);
			
			
			}
		 public function listarTarefasDiarias ($iduser){
		 
			if($iduser == 0){
				$query = $this->_myDb->prepare("SELECT * FROM tarefas_diarias INNER JOIN clientes ON tarefas_diarias.cliente_tar_diaria=clientes.id_cliente INNER JOIN users ON tarefas_diarias.user_tar_diaria=users.id_user order by id_tar_diaria desc ");
			}
			else{
				$query = $this->_myDb->prepare("SELECT * FROM tarefas_diarias INNER JOIN clientes ON tarefas_diarias.cliente_tar_diaria=clientes.id_cliente INNER JOIN users ON tarefas_diarias.user_tar_diaria=users.id_user where user_tar_diaria = :iduser order by id_tar_diaria desc ");
				$query->bindParam(":iduser", $iduser);
				$iduser = $iduser;
			}
			$query -> execute();
			return ($query);
		 
		 }
		 

		  public function listarMinhasTarefas ($iduser){
		 
	
			$query = $this->_myDb->prepare("SELECT * FROM tarefas INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tarefas.prioridade_id = prioridade.id_prioridade INNER JOIN intervenientes_tarefa ON tarefas.id_tarefa = intervenientes_tarefa.tarefa_interv_id INNER JOIN users on intervenientes_tarefa.user_interv_id = users.id_user INNER JOIN ordem on tarefas.id_tarefa = ordem.id_tarefa_ordem WHERE id_user = :iduser AND id_user_ordem = :iduser AND processada = 0 GROUP BY id_tarefa ORDER BY tipo_tarefa desc, CHAR_LENGTH(valor_ordem), valor_ordem asc");
			$query->bindParam(":iduser", $iduser);
			$iduser = $iduser;
			
			$query -> execute();
			return ($query);
		 
		 }


		 public function listarIntervenientes(){
			$query = $this->_myDb->prepare("SELECT * FROM intervenientes_tarefa") ;
			$query -> execute();
			return ($query);
		 }

		  public function listarTarefasUrg (){
		 
			$query = $this->_myDb->prepare("SELECT * FROM tarefas INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tarefas.prioridade_id=prioridade.id_prioridade WHERE `urgente`= 1") ;
			$query -> execute();
			return ($query);
		 
		 }


		  public function listarUsers (){
		 
			$query = $this->_myDb->prepare("SELECT * FROM users ") ;	
			$query -> execute();
			return ($query);
		 
		 }


		 public function listarMensagens ($idtarefa){
		 
	
			$query = $this->_myDb->prepare("SELECT * FROM mensagens INNER JOIN users ON mensagens.user_id_msg=users.id_user WHERE tarefa_id_msg = :idtarefa ORDER BY id_msg desc  ") ;
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;
			$query -> execute();
			return ($query);
		 
		 }

		 public function listarClientes (){
		 
			$query = $this->_myDb->prepare("SELECT * FROM clientes ORDER BY nome  ") ; 
			$query -> execute();
			return ($query);
		 
		 }


		 public function listMyTasks ($iduser){
		 
			$query = $this->_myDb->prepare("SELECT * FROM tasks INNER JOIN tarefas ON tasks.tarefa_id_task=tarefas.id_tarefa INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tasks.prioridade_task = prioridade.id_prioridade WHERE user_id_task = :iduser ORDER BY prioridade_id desc  ") ; 
			$query->bindParam(":iduser", $iduser);
			$iduser = $iduser;
			$query -> execute();
			return ($query);
		 
		 }


		  public function listTasks (){
		 
			$query = $this->_myDb->prepare("SELECT * FROM tasks INNER JOIN tarefas ON tasks.tarefa_id_task=tarefas.id_tarefa INNER JOIN users on tasks.user_id_task=users.id_user INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tasks.prioridade_task = prioridade.id_prioridade ORDER BY id_task desc ") ;
			$query -> execute();
			return ($query);
		 
		 }

		 
		 public function listSingleTask ($idtask){
		 
			$query = $this->_myDb->prepare("SELECT * FROM tasks INNER JOIN tarefas ON tasks.tarefa_id_task=tarefas.id_tarefa INNER JOIN users on tasks.user_id_task=users.id_user INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente INNER JOIN prioridade ON tasks.prioridade_task = prioridade.id_prioridade WHERE id_task = :idtask ") ;
			$query->bindParam(":idtask", $idtask);
			$idtask = $idtask;
			$query -> execute();
			return ($query);
		 
		 }
		 

		 
		 public function deleteTarefa($idtarefa) {
			 
			 $query = $this->_myDb->prepare("DELETE FROM tarefas WHERE id_tarefa = :idtarefa");
			 $query->bindParam(":idtarefa", $idtarefa);
			 $idtarefa = $idtarefa;
			 $query -> execute();
			 return ($query);
			 
		 }
		 
		 
		 public function deleteTarefaDiaria($idtarefa) {
			 
			 $query = $this->_myDb->prepare("DELETE FROM tarefas_diarias WHERE id_tar_diaria = :idtarefa");
			 $query->bindParam(":idtarefa", $idtarefa);
			 $idtarefa = $idtarefa;
			 $query -> execute();
			 return ($query);
			 
		 }


		 public function deleteCliente($idcliente) {
			 
			 $query = $this->_myDb->prepare("DELETE FROM clientes WHERE id_cliente = :idcliente");
			 $query->bindParam(":idcliente", $idcliente);
			 $idcliente = $idcliente;	 
			 $query -> execute();
			 return ($query);
			 
		 }


		 public function deleteIntervenientesByTarefa($idtarefa) {
			 
			 $query = $this->_myDb->prepare("DELETE FROM intervenientes_tarefa WHERE tarefa_interv_id = :idtarefa");
			 $query->bindParam(":idtarefa", $idtarefa);
			 $idtarefa = $idtarefa;	 
			 $query -> execute();
			 return ($query);
		 }


		  public function deleteMessagesByTarefa($idtarefa) {
			 
			 $query = $this->_myDb->prepare("DELETE FROM mensagens WHERE tarefa_id_msg = :idtarefa");
			 $query->bindParam(":idtarefa", $idtarefa);
			 $idtarefa = $idtarefa;	 
			 $query -> execute();
			 return ($query);
		 }
		 
		 public function deleteNotificacaoByTarefa($idtarefa) {
			
			$query = $this->_myDb->prepare("DELETE FROM notificacoes WHERE not_tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;	 
			$query -> execute();
			return ($query);
		}

		public function deleteNotificacaoMensagemByTarefa($idtarefa) {
			
			$query = $this->_myDb->prepare("DELETE FROM notificacoes_mensagens WHERE tarefa_not_msg = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;	 
			$query -> execute();
			return ($query);
		}

		public function deleteOrdem($idtarefa) {
			
			$query = $this->_myDb->prepare("DELETE FROM ordem WHERE id_tarefa_ordem = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;	 
			$query -> execute();
			return ($query);
		}
		
		
		public function deleteHoras($idtarefa) {
			
			$query = $this->_myDb->prepare("DELETE FROM horas WHERE tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;	 
			$query -> execute();
			return ($query);
		}
		
		public function deleteObservacoes($idtarefa) {
			
			$query = $this->_myDb->prepare("DELETE FROM observacoes WHERE id_tarefa_observacao = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;	 
			$query -> execute();
			return ($query);
		}
		
		public function deleteHora($idhora) {
			
			$query = $this->_myDb->prepare("DELETE FROM horas WHERE id_hora = :idhora");
			$query->bindParam(":idhora", $idhora);
			$idhora = $idhora;	 
			$query -> execute();
			return ($query);
		}
		
		public function deleteObservacao($idobs) {
			
			$query = $this->_myDb->prepare("DELETE FROM observacoes WHERE id_observacao = :idobs");
			$query->bindParam(":idobs", $idobs);
			$idobs = $idobs;	 
			$query -> execute();
			return ($query);
		}

		public function deleteTarefaFaturada($idtarefa) {
			
			$query = $this->_myDb->prepare("DELETE FROM tarefas_faturadas WHERE tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;	 
			$query -> execute();
			return ($query);
		}


		public function deleteCustosTarefa($idtarefa) {
			
			$query = $this->_myDb->prepare("DELETE FROM custos_tarefa WHERE tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;	 
			$query -> execute();
			return ($query);
		}


		 
		 public function contarTarefas(){

				$query = $this->_myDb->prepare("SELECT COUNT(*) AS total FROM tarefas where concluido = :concluido ");
				$query->bindParam(":concluido", $concluido);
			 	$concluido = 0;
				$query -> execute();
				$row = $query->fetchAll(PDO::FETCH_ASSOC);
				$count = $row[0]['total'];
				return($count);
		}


		public function contarTasks($idtarefa){

			$query = $this->_myDb->prepare("SELECT COUNT(*) AS total FROM tasks where tarefa_id_task = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);

		}


		public function contarTarefasCliente($idcliente){

			$query = $this->_myDb->prepare("SELECT COUNT(*) AS total FROM tarefas where cliente_id = :idcliente ");
			$query->bindParam(":idcliente", $idcliente);
			$idcliente = $idcliente;
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);

		}
		
		
		public function contarTarefasClienteProcessadas($idcliente){
			
			$query = $this->_myDb->prepare("SELECT COUNT(*) AS total FROM tarefas where cliente_id = :idcliente and processada = 1 and faturada = 3 ");
			$query->bindParam(":idcliente", $idcliente);
			$idcliente = $idcliente;
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);
			
		}


		public function contarNotificacoes($iduser){

			$query = $this->_myDb-> prepare("SELECT COUNT(*) AS total FROM notificacoes WHERE not_user_id = :iduser AND aberta = :aberta ");
			$query->bindParam(":iduser", $iduser);
			$query->bindParam(":aberta", $aberta);
			$iduser = $iduser;		 
			$aberta = 0;
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);
		
		}
		
		
		
		public function contarNotificacoesMensagens($iduser){

			$query = $this->_myDb-> prepare("SELECT COUNT(*) AS total FROM notificacoes_mensagens WHERE user_not_msg = :iduser AND aberta_not_msg = :aberta ");
			$query->bindParam(":iduser", $iduser);
			$query->bindParam(":aberta", $aberta);
			$iduser = $iduser;		 
			$aberta = 0;
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);
		
		}
		
		
		public function contarNotificacoesHoras($iduser){
			
			$query = $this->_myDb-> prepare("SELECT COUNT(*) AS total FROM horas WHERE user_id = :iduser AND hora_fim = '' ");
			$query->bindParam(":iduser", $iduser);
			$iduser = $iduser;		 
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);
					
		}


		public function listAllUsers(){
			
						$query = $this->_myDb->prepare("SELECT * from users where inativo != '1' order by nome_user asc");
						$query -> execute();
						return($query);
			
		}


		public function listUsersCargo($cargo){
			
			$query = $this->_myDb->prepare("SELECT * from users where inativo != '1' and cargo = :cargo order by nome_user asc");
			$query->bindParam(":cargo", $cargo);
			$cargo = $cargo;
			$query -> execute();
			return($query);

		}		


		public function getNotificacoes($iduser){

			$query = $this->_myDb-> prepare("SELECT * FROM notificacoes INNER JOIN tarefas ON notificacoes.not_tarefa_id=tarefas.id_tarefa WHERE not_user_id = :iduser ORDER BY id_not desc LIMIT 10 ");
			$query->bindParam(":iduser", $iduser);

			$iduser = $iduser;		 
			$query -> execute();
			return ($query);

		}
		
		
		public function getNotificacoesMensagens($iduser){

			$query = $this->_myDb-> prepare("SELECT * FROM notificacoes_mensagens INNER JOIN tarefas ON notificacoes_mensagens.tarefa_not_msg=tarefas.id_tarefa INNER JOIN clientes ON tarefas.cliente_id=clientes.id_cliente WHERE user_not_msg = :iduser ORDER BY id_not_msg desc LIMIT 10 ");
			$query->bindParam(":iduser", $iduser);
			//$query->bindParam(":aberta", $aberta);
			$iduser = $iduser;		 
			//$aberta = 0;
			$query -> execute();
			return ($query);

		}
		
		
			public function getNotificacoesHoras($iduser){
			
						$query = $this->_myDb-> prepare("SELECT * FROM horas INNER JOIN tarefas ON horas.tarefa_id=tarefas.id_tarefa WHERE user_id = :iduser AND hora_fim = '' ORDER BY id_Hora desc");
						$query->bindParam(":iduser", $iduser);
						//$query->bindParam(":aberta", $aberta);
						$iduser = $iduser;		 
						//$aberta = 0;
						$query -> execute();
						return ($query);
			
					}


		public function notificacaoVista($idnotificacao, $iduser){

			$query = $this->_myDb-> prepare("UPDATE notificacoes set aberta='1' WHERE id_not= :idnotificacao AND not_user_id = :iduser");
			$query->bindParam(":idnotificacao", $idnotificacao);
			$query->bindParam(":iduser", $iduser);
			$iduser = $iduser;		 
			$idnotificacao = $idnotificacao;
			$query -> execute();
			return ($query);

		}
		
		
		public function notificacaoMensagemVista($idnotificacao, $iduser){

			$query = $this->_myDb-> prepare("UPDATE notificacoes_mensagens set aberta_not_msg='1' WHERE id_not_msg= :idnotificacao AND user_not_msg = :iduser");
			$query->bindParam(":idnotificacao", $idnotificacao);
			$query->bindParam(":iduser", $iduser);
			$iduser = $iduser;		 
			$idnotificacao = $idnotificacao;
			$query -> execute();
			return ($query);

		}
		

		public function apagarVisto($idtarefa, $iduser){
			$query = $this->_myDb-> prepare("DELETE FROM mensagem_vista WHERE tarefa_vista_id = :idtarefa and user_vista_id = :iduser ");
			$query->bindParam(":idtarefa", $idtarefa);
			$query->bindParam(":iduser", $iduser);
			$iduser = $iduser;		 
			$idtarefa = $idtarefa;
			$query -> execute();
			return ($query);	

		}

		
		public function usersVisto($idtarefa){

			$query = $this->_myDb-> prepare("SELECT * FROM users WHERE users.id_user NOT IN (SELECT user_vista_id FROM mensagem_vista Where tarefa_vista_id = :idtarefa)");
			$query->bindParam(":idtarefa", $idtarefa);
			$idtarefa = $idtarefa;
			$query -> execute();
			return ($query);

		}


		public function usersTarefa($idtarefa){

			$query = $this->_myDb-> prepare("Select * from intervenientes_tarefa INNER JOIN users on intervenientes_tarefa.user_interv_id=users.id_user where tarefa_interv_id = '$idtarefa'");
			$query->bindParam(":idtarefa", $idtarefa);	 
			$idtarefa = $idtarefa;
			$query -> execute();
			return ($query);

		}
		
		
		public function inicioHora($iduser, $idtarefa, $horastart, $dia){
				
							$query = $this->_myDb-> prepare("INSERT INTO horas (user_id, tarefa_id, hora_inicio, dia) VALUES (:iduser, :idtarefa, :horastart, :dia)");
							$query->bindParam(":iduser", $iduser);
							$query->bindParam(":idtarefa", $idtarefa);
							$query->bindParam(":horastart", $horastart);
							$query->bindParam(":dia", $dia);
							$iduser = $iduser;
							$idtarefa = $idtarefa;
							$horastart = $horastart;
							$dia = $dia;
							$query -> execute();
							echo '<script>location.href = "list_my_tarefas.php";</script>';
				
						}


			public function fimHora($iduser, $idtarefa, $horafim){
							
							$query = $this->_myDb-> prepare("UPDATE horas set hora_fim = :horafim WHERE user_id = :iduser and tarefa_id = :idtarefa order by id_hora desc limit 1");
							$query->bindParam(":iduser", $iduser);
							$query->bindParam(":idtarefa", $idtarefa);
							$query->bindParam(":horafim", $horafim);
							$iduser = $iduser;
							$idtarefa = $idtarefa;
							$horafim = $horafim;
							$query -> execute();
							echo '<script>location.href = "list_my_tarefas.php";</script>';
							
						}


		public function contarHoras($idtarefa){
						
						$query = $this->_myDb-> prepare("SELECT * FROM horas INNER JOIN users on horas.user_id=users.id_user where tarefa_id = :idtarefa and hora_fim<>''");
						$query->bindParam(":idtarefa", $idtarefa);	 
						$idtarefa = $idtarefa;
						$query -> execute();
						return ($query);
						
					}


		public function registosHoras($idtarefa){
						
						$query = $this->_myDb-> prepare("SELECT COUNT(*) AS total FROM horas where tarefa_id = :idtarefa and hora_fim<>''");
						$query->bindParam(":idtarefa", $idtarefa);	 
						$idtarefa = $idtarefa;
						$query -> execute();
						$row = $query->fetchAll(PDO::FETCH_ASSOC);
						$count = $row[0]['total'];
						return($count);
						
					}


		public function registosFaturacoes($idtarefa){
			
			$query = $this->_myDb-> prepare("SELECT * from tarefas_faturadas INNER JOIN users on tarefas_faturadas.user_id = users.id_user WHERE tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);	 
			$idtarefa = $idtarefa;
			$query -> execute();
			return($query);
			
		}


		public function contarRegistosCustosTarefa($idtarefa){
						
			$query = $this->_myDb-> prepare("SELECT COUNT(*) AS total FROM custos_tarefa where tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);	 
			$idtarefa = $idtarefa;
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);
			
		}


		public function listarRegistosCustosTarefa($idtarefa){
			
			$query = $this->_myDb-> prepare("SELECT * from custos_tarefa WHERE tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);	 
			$idtarefa = $idtarefa;
			$query -> execute();
			return($query);
			
		}


		public function registosConcluida($idtarefa){
			
			$query = $this->_myDb-> prepare("SELECT * from tarefas_concluidas INNER JOIN users on tarefas_concluidas.user_id = users.id_user WHERE tarefa_id = :idtarefa");
			$query->bindParam(":idtarefa", $idtarefa);	 
			$idtarefa = $idtarefa;
			$query -> execute();
			return($query);
			
		}

		
		public function consultaHoras($iduser, $idtarefa){
						
						$query = $this->_myDb-> prepare("SELECT * FROM horas WHERE user_id = :iduser and tarefa_id = :idtarefa order by id_hora desc limit 1");
						$query->bindParam(":idtarefa", $idtarefa);
						$query->bindParam(":iduser", $iduser);
						$idtarefa = $idtarefa;
						$iduser = $iduser;
						$query -> execute();
						return($query);
						
					}
	    
	    
	    
	    public function processarTarefa($idtarefa, $observacoes, $valfaturada, $titulotarefa){
							
					$query = $this->_myDb-> prepare("UPDATE tarefas set processada = 1, observacoes_faturacao = :observacoes WHERE id_tarefa = :idtarefa");
					$query->bindParam(":idtarefa", $idtarefa);
					$query->bindParam(":observacoes", $observacoes);
					$idtarefa = $idtarefa;		 
					$observacoes = $this->purificar($observacoes);
					$query -> execute();

					if($valfaturada == 0){
						$to      = 'contabilidade@invisual.pt';
						$subject = "Nova Tarefa para Faturar - '".$titulotarefa."'";
						$message = "A Tarefa '<strong>".$titulotarefa."</strong>' foi Processada e definida como 'Em Análise' ou 'Por Faturar'.
						<br><br>
						Pode vê-la e actualizar o seu estado aqui: <a href='https://tarefas.invisual.pt/listar_tarefa.php?id=".$idtarefa."'>Ver Tarefa</a>";
						$headers = "From: tarefas@invisual.pt" . "\r\n";
						$headers .= "Reply-To: tarefas@invisual.pt" . "\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

						mail($to, $subject, $message, $headers);
					}
						
							
			}



			public function inserirRegistoProcessarTarefa($idtarefa, $user){
							
				$query = $this->_myDb-> prepare("INSERT INTO tarefas_concluidas (tarefa_id, user_id) VALUES (:idtarefa, :user)");
				$query->bindParam(":idtarefa", $idtarefa);
				$query->bindParam(":user", $user);
				$idtarefa = $idtarefa;		 
				$user = $user;
				$query -> execute();
				return ($query);
				
			}



			public function tarefasAjaxCliente($cliente, $mes){


						if(empty($mes)){
							$query = $this->_myDb->prepare("SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' and nome LIKE '%$cliente%' GROUP BY id_tarefa");
						}
						else if(empty($cliente)){
							$query = $this->_myDb->prepare("SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' and dia LIKE '%/$mes' GROUP BY id_tarefa");
						}
						else if(!empty($cliente) && !empty($mes)){
							$query = $this->_myDb->prepare("SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' and nome LIKE '%$cliente%' and dia LIKE '%/$mes' GROUP BY id_tarefa");
						}
						$cliente = $this->purificar($cliente);
						$mes = $this->purificar($mes);
						$query -> execute();
						return ($query);
											
			}



			public function tarefasAjax(){

						$query = $this->_myDb->prepare("SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' GROUP BY id_tarefa");
						$query -> execute();
						return ($query);
											
			}



			public function horasAjax($idtarefa){
				

						$query = $this->_myDb->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais'  FROM `horas` WHERE tarefa_id= $idtarefa");
				
						$idtarefa = $this->purificar($idtarefa);
						$query -> execute();
						return ($query);
											
			}
			
			
			
			public function horasAjaxMes($idtarefa, $mesativo){
				

						$query = $this->_myDb->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais'  FROM `horas` WHERE tarefa_id= $idtarefa and dia LIKE '%/$mesativo'");
				
						$idtarefa = $this->purificar($idtarefa);
						$mesativo = $this->purificar($mesativo);
						$query -> execute();
						return ($query);
											
			}
			
			
			
			public function limparNotificacoes($iduser){
				

						$query = $this->_myDb->prepare("UPDATE notificacoes set aberta = 1 where not_user_id = $iduser");
				
						$iduser = $this->purificar($iduser);
						$query -> execute();
						return ($query);
											
			}
			
			
			public function getUser($idutilizador){
				
				$query = $this->_myDb->prepare("SELECT *  FROM users WHERE id_user = :idutilizador ") ; 
	   
				$query->bindParam(":idutilizador", $idutilizador);
				$idutilizador =$idutilizador;
				$query -> execute();
				return ($query);
				
		}
		
		
		public function contarTarefasClienteAvenca($idcliente){
			
			$query = $this->_myDb->prepare("SELECT COUNT(*) AS total FROM tarefas where cliente_id = :idcliente and faturada = 2");
			$query->bindParam(":idcliente", $idcliente);
			$idcliente = $idcliente;
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);
			
		}
		
		
		
		public function listarClientesAvenca (){
			
			   $query = $this->_myDb->prepare("SELECT * FROM clientes where horas_mensais > 0 ORDER BY nome") ; 
			   $query -> execute();
			   return ($query);
			
		}
		
		
		
		public function horasClienteMes($idcliente, $mes){
				

						$query = $this->_myDb->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais'  FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente  WHERE id_cliente= $idcliente and faturada = 2 and dia LIKE '%/$mes'");
				
						$idcliente = $this->purificar($idcliente);
						$mes = $this->purificar($mes);
						$query -> execute();
						$row = $query->fetchAll(PDO::FETCH_ASSOC);
						$count = $row[0]['horastotais'];
						return($count);
											
		}
		
		
		
		public function avencarTarefa($idtarefa, $val){
				
							$query = $this->_myDb-> prepare("UPDATE tarefas set avenca = :val WHERE id_tarefa = :idtarefa");
							$query->bindParam(":idtarefa", $idtarefa);
							$query->bindParam(":val", $val);
							$idtarefa = $idtarefa;		 
							$val = $val;
							$query -> execute();
							return ($query);
				
			}
			
			
		
		public function contarHorasTarefas($idtarefa){
				

						$query = $this->_myDb->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais'  FROM `horas` WHERE tarefa_id= $idtarefa");
				
						$idtarefa = $this->purificar($idtarefa);
						$query -> execute();
						$row = $query->fetchAll(PDO::FETCH_ASSOC);
						$count = $row[0]['horastotais'];
						return($count);
											
			}
			
	    
	    public function checkHoraAbertaTarefas($iduser, $idtarefa){
			
			$query = $this->_myDb-> prepare("SELECT COUNT(*) AS total FROM horas WHERE user_id = :iduser AND tarefa_id = :idtarefa AND hora_fim = '' ");
			$query->bindParam(":iduser", $iduser);
			$query->bindParam(":idtarefa", $idtarefa);
			$iduser = $iduser;	
			$idtarefa = $idtarefa;		 
			$query -> execute();
			$row = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $row[0]['total'];
			return($count);
					
		}
		
		
		public function TarefasPorUtilizador($iduser){
				
							$query = $this->_myDb-> prepare("SELECT COUNT(*) AS total FROM tarefas INNER JOIN intervenientes_tarefa ON tarefas.id_tarefa = intervenientes_tarefa.tarefa_interv_id WHERE user_interv_id = :iduser AND estado != :estado AND processada = :processada ");
							$query->bindParam(":iduser", $iduser);
							$query->bindParam(":estado", $estado);
							$query->bindParam(":processada", $processada);
							$iduser = $iduser;		 
							$estado = 2;
							$processada = 0;
							$query -> execute();
							$row = $query->fetchAll(PDO::FETCH_ASSOC);
							$count = $row[0]['total'];
							return($count);
						
			}



			public function CargoUtilizador($iduser){
				
							$query = $this->_myDb-> prepare("SELECT nome_cargo_user FROM users  WHERE id_user = :iduser");
							$query->bindParam(":iduser", $iduser);
							$iduser = $iduser;		 
							$query -> execute();
							return ($query);
				
			}
			
			public function horasUtilizador($iduser){
				
							$query = $this->_myDb-> prepare("SELECT * FROM horas INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where user_id = :iduser ");
							$query->bindParam(":iduser", $iduser);
				
							$iduser = $iduser;		 
							$query -> execute();
							return ($query);
				
			}
			
			
			
			public function getLastId(){
				
				$query = $this->_myDb-> prepare("SELECT * FROM tarefas ORDER BY id_tarefa DESC LIMIT 1");
		 
				$query -> execute();
				return ($query);
	
			}
		
		
		
	    
	    
}

?>