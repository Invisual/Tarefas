<?php
header('Content-Type: application/json');
        include "db.php";
        
        $arraycompleto = [];
        
        $data=array();
        $q=mysqli_query($con,"SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' GROUP BY id_tarefa ORDER BY id_tarefa DESC");
        mysqli_set_charset( $con, 'utf8');
        
    
    while ($row=mysqli_fetch_assoc($q)){

      $intervenientesquery=mysqli_query($con,"select user_interv_id from `intervenientes_tarefa` where tarefa_interv_id = '".$row['id_tarefa']."'" );
      $intervenientesarray = [];
      while($intervenientesrow=mysqli_fetch_assoc($intervenientesquery)){
        $intervenientesarray[] = $intervenientesrow['user_interv_id'];
      }
      $row['intervenientes'] = $intervenientesarray;


      $horastarefaquery=mysqli_query($con,"select id_hora, dia from `horas` where tarefa_id = '".$row['id_tarefa']."'" );
      $horastarefaarray = [];
      $diastarefaarray = [];
      while($horastarefarow=mysqli_fetch_assoc($horastarefaquery)){
        $horastarefaarray[] = $horastarefarow['id_hora'];
        $diastarefaarray[] = $horastarefarow['dia'];
      }
      if(!$diastarefaarray){
        $diastarefaarray = ['1/13'];
      }
      $row['horas_tarefa'] = $horastarefaarray;
      $row['dias_tarefa'] = $diastarefaarray;


      $data[] = $row;
      
    }
    $arraycompleto['tarefas'] = $data;




    $usersquery=mysqli_query($con,"select id_user, nome_user, img from `users`" );
    $userarray = [];
    while($userrow=mysqli_fetch_assoc($usersquery)){
      $userarray[$userrow['id_user']] = ['nome' => $userrow['nome_user'], 'img' => $userrow['img']];
    }
    $arraycompleto['users'] = $userarray;


    
    $horasquery=mysqli_query($con,"select id_hora, hora_inicio, hora_fim, dia from `horas`" );
    $horasarray = [];
    while($horasrow=mysqli_fetch_assoc($horasquery)){
      $horasarray[$horasrow['id_hora']] = ['hora_inicio' => $horasrow['hora_inicio'], 'hora_fim' => $horasrow['hora_fim'], 'dia' => $horasrow['dia']];
    }
    $arraycompleto['horas'] = $horasarray;


    echo json_encode($arraycompleto);

