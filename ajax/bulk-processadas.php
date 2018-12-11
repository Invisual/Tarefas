<?php

        include "db.php";
        mysqli_set_charset( $con, 'utf8');
      
        
        $id=$_GET['id'];
        $option = $_GET['option'];
        $faturada = $_GET['faturada'];
        mysqli_query($con,"UPDATE tarefas set faturada = '$option', foi_faturada = '$faturada' where id_tarefa='$id'");
        if($faturada == 1){
                mysqli_query($con,"INSERT INTO tarefas_faturadas (tarefa_id) VALUES ('$id')");
        }
        


       
?>

