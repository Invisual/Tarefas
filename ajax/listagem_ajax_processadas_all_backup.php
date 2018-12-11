<?php
header('Content-Type: application/json');
        include "db.php";
        
        
        $data=array();
        $q=mysqli_query($con,"SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' GROUP BY id_tarefa");
        mysqli_set_charset( $con, 'utf8');
        
    
    while ($row=mysqli_fetch_assoc($q)){
      $data[] = $row;
     
    }

    echo json_encode($data);
       
?>

