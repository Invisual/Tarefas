<?php

        include "db.php";
        mysqli_set_charset( $con, 'utf8');
      
        
        $id=$_GET['id'];
        mysqli_query($con,"UPDATE tarefas set processada = 1, faturada = 3 where id_tarefa='$id'");
        


?>

