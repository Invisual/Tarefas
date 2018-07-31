<?php
header('Content-Type: application/json');
        include "db.php";
        
        
        $data=array();

        $cliente = $_POST['cliente'];
        $user = $_POST['user'];
        $estado = $_POST['estado'];

        if($cliente == '-'){
          $clienteVal = "like '%'";
        }
        else{
          $clienteVal = "= '".$cliente."'";
        }


        if($user == '-'){
          $userVal = "like '%'";
        }
        else{
          $userVal = "= '".$user."'";
        }


        if($estado == '-'){
          $estadoVal = "like '%'";
        }
        else{
          $estadoVal = "= '".$estado."'";
        }



        $user = "like '%'";
        $estado = "like '%'";
        $q=mysqli_query($con,"select * from `tarefas` INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente INNER JOIN intervenientes_tarefa on tarefas.id_tarefa = intervenientes_tarefa.tarefa_interv_id where id_cliente $clienteVal and user_interv_id $userVal and estado $estadoVal and processada = 0 GROUP BY id_tarefa");
        mysqli_set_charset( $con, 'utf8');
        
    
    while ($row=mysqli_fetch_assoc($q)){
      $data[] = $row;
     
    }

    echo json_encode($data);
       
?>

