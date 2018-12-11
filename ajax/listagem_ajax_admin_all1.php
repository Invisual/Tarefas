<?php
header('Content-Type: application/json');
        include "db.php";
        
        
        $data=array();
        $q=mysqli_query($con,"select * from `tarefas` INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente INNER JOIN intervenientes_tarefa on tarefas.id_tarefa = intervenientes_tarefa.tarefa_interv_id where processada = 0 GROUP BY id_tarefa");
        mysqli_set_charset( $con, 'utf8');
        
    
    while ($row=mysqli_fetch_assoc($q)){
      $data[] = $row;
     
    }

    echo json_encode($data);
       
?>

