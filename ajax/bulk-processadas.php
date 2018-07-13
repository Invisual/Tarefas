<?php

        include "db.php";
        mysqli_set_charset( $con, 'utf8');
      
        
        $id=$_GET['id'];
        $option = $_GET['option'];
        mysqli_query($con,"UPDATE tarefas set faturada = '$option' where id_tarefa='$id'");
        


       
?>

