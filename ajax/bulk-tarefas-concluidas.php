<?php

        include "db.php";
        mysqli_set_charset( $con, 'utf8');
        
        $id=$_GET['id'];
        $valfaturada=$_GET['faturacao'];
        $titulotarefa=$_GET['titulo'];
        $user=$_GET['user'];
        mysqli_query($con,"UPDATE tarefas set processada = 1 where id_tarefa='$id'");
        mysqli_query($con,"INSERT INTO tarefas_concluidas (tarefa_id, user_id) VALUES ($id, $user)");
        if($valfaturada == 0 || $valfaturada == 3){
                $to      = 'contabilidade@invisual.pt';
                $subject = "Nova Tarefa para Faturar - '".$titulotarefa."'";
                $message = "A Tarefa '<strong>".$titulotarefa."</strong>' foi Processada e definida como 'Em Análise' ou 'Por Faturar'.
                <br><br>
                Pode vê-la e actualizar o seu estado aqui: <a href='https://tarefas.invisual.pt/listar_tarefa.php?id=".$id."'>Ver Tarefa</a>";
                $headers = "From: tarefas@invisual.pt" . "\r\n";
                $headers .= "Reply-To: tarefas@invisual.pt" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                mail($to, $subject, $message, $headers);
        }
        

?>

