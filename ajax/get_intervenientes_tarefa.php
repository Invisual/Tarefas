<?php
header('Content-Type: application/json');
        include "db.php";
        
        
        $data=array();

        $tarefa = $_POST['tarefa'];

        $q=mysqli_query($con,"select * from `intervenientes_tarefa` INNER JOIN users on intervenientes_tarefa.user_interv_id = users.id_user where tarefa_interv_id = $tarefa");
        mysqli_set_charset( $con, 'utf8');
        
    
    while ($row=mysqli_fetch_assoc($q)){
      $data[] = $row;
     
    }

    echo json_encode($data);
       
?>

