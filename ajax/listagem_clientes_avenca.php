<?php
header('Content-Type: application/json');
include "db.php";
$arraycompleto = [];
$data=array();

$q=mysqli_query($con,"SELECT * from clientes where horas_mensais != 0");
mysqli_set_charset( $con, 'utf8');


while ($row=mysqli_fetch_assoc($q)){

    //Janeiro
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/01' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Janeiro'] = $horasarray;




    //Fevereiro
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/02' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Fevereiro'] = $horasarray;





    //Marco
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/03' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Marco'] = $horasarray;






    //Abril
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/04' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Abril'] = $horasarray;






    //Maio
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/05' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Maio'] = $horasarray;






    //Junho
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/06' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Junho'] = $horasarray;




    //Julho
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/07' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Julho'] = $horasarray;





    //Agosto
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/08' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Agosto'] = $horasarray;





    //Setembro
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/09' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Setembro'] = $horasarray;





    //Outubro
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/10' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Outubro'] = $horasarray;




    //Novembro
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/11' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Novembro'] = $horasarray;





    //Dezembro
    $horasquery=mysqli_query($con,"SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_fim, hora_inicio)))) AS 'horastotais', nome FROM `horas` INNER JOIN tarefas on horas.tarefa_id = tarefas.id_tarefa INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente WHERE id_cliente = '".$row['id_cliente']."' AND faturada = 2 and dia LIKE '%/12' GROUP BY id_cliente" );
    $horasarray = [];

    while($horasrow=mysqli_fetch_assoc($horasquery)){
        $horasarray[] = $horasrow['horastotais'];
    }

    $row['Dezembro'] = $horasarray;





    $data[] = $row;
}

$arraycompleto['clientes'] = $data;

echo json_encode($arraycompleto);
       
?>

