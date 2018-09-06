<?php
header('Content-Type: application/json');
        include "db.php";
        
        
        $data=array();

        $cliente = $_POST['cliente'];
        $mes = $_POST['mes'];
        $faturada = $_POST['faturada'];

        if($cliente == '-'){
          $clienteVal = "like '%'";
        }
        else{
          $clienteVal = "= '".$cliente."'";
        }


        if($mes == '-'){
          $mesVal = "like '%'";
          $mesIsSet = false;
        }
        else{
          $mesVal = "like '%/".$mes."'";
          $mesIsSet = true;
        }


        if($faturada == '-'){
          $faturadaVal = "like '%'";
        }
        else{
          $faturadaVal = "= '".$faturada."'";
        }



        $mes = "like '%'";
        $faturada  = "like '%'";
        if($mesIsSet){
          $q=mysqli_query($con,"SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' and id_cliente $clienteVal and dia $mesVal and faturada $faturadaVal GROUP BY id_tarefa");
        mysqli_set_charset( $con, 'utf8');
        }
        else{
          $q=mysqli_query($con,"SELECT * FROM tarefas LEFT JOIN horas on tarefas.id_tarefa = horas.tarefa_id INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente where processada= '1' and id_cliente $clienteVal and faturada $faturadaVal GROUP BY id_tarefa");
        mysqli_set_charset( $con, 'utf8');
        }
        

    while ($row=mysqli_fetch_assoc($q)){
      $data[] = $row;
     
    }

    echo json_encode($data);
       
?>

