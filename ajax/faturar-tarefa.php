<?php   
        session_start();
        include "db.php";
        mysqli_set_charset( $con, 'utf8');
      
        $id=$_GET['id'];
        $val = $_GET['val'];
        $faturada = $_GET['faturada'];
        $user = $_SESSION['id'];
        mysqli_query($con,"UPDATE tarefas set faturada = '$faturada', foi_faturada = '$val' where id_tarefa='$id'");
        if($faturada == 1){
                mysqli_query($con,"INSERT INTO tarefas_faturadas (tarefa_id, user_id) VALUES ('$id', '$user')");
        }
        
?>

