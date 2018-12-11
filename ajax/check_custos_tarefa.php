<?php

        include "db.php";
        
        $id=$_GET['id'];

        $q = mysqli_query($con,"SELECT * from custos_tarefa WHERE tarefa_id='$id'");
        mysqli_set_charset( $con, 'utf8');
        
        $rows = 0;
        while ($row=mysqli_fetch_assoc($q)){
          $rows++;
        }
    
        echo $rows;
       
?>

