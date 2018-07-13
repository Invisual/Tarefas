<?php
header('Content-Type: application/json');
        include "db.php";
        
        if(isset($_POST[id])){
        
        $id=$_POST['id'];
        $data=array();
        $q=mysqli_query($con,"select * from `tarefas` INNER JOIN intervenientes_tarefa on tarefas.id_tarefa=intervenientes_tarefa.tarefa_interv_id where cliente_id='$id' AND processada = '1' AND faturada = '3'");
        mysqli_set_charset( $con, 'utf8');
        
        }
        
        else{
            $data=array();
        $q=mysqli_query($con,"select * from `tarefas` INNER JOIN intervenientes_tarefa on tarefas.id_tarefa=intervenientes_tarefa.tarefa_interv_id where processada = 1 and faturada = 3");
        mysqli_set_charset( $con, 'utf8');
        }
    
    while ($row=mysqli_fetch_assoc($q)){
      $data[] = $row;
     
    }

    echo json_encode($data);
       
?>

