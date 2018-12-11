<?php
header('Content-Type: application/json');
include "db.php";
$arraycompleto = [];
$data=array();

$q=mysqli_query($con,"SELECT * FROM tarefas INNER JOIN clientes on tarefas.cliente_id = clientes.id_cliente INNER JOIN tarefas_faturadas ON tarefas.id_tarefa = tarefas_faturadas.tarefa_id LEFT JOIN custos_tarefa ON tarefas.id_tarefa = custos_tarefa.tarefa_id INNER JOIN users on tarefas_faturadas.user_id = users.id_user where processada= '1' and foi_faturada = '1' GROUP BY id_tarefa");
mysqli_set_charset( $con, 'utf8');


while ($row=mysqli_fetch_assoc($q)){

    $custosquery=mysqli_query($con,"select * from `custos_tarefa` where tarefa_id = '".$row['id_tarefa']."'" );
    $custossarray = [];

    while($custosrow=mysqli_fetch_assoc($custosquery)){
        $custossarray[] = $custosrow['id_custo_tarefa'];
    }

    $row['custos'] = $custossarray;

    $data[] = $row;
}

$arraycompleto['tarefas'] = $data;


$custosTotaisQuery=mysqli_query($con,"select * from `custos_tarefa`" );
$custosTotaisArray = [];
while($custosTotaisrow=mysqli_fetch_assoc($custosTotaisQuery)){
  $custosTotaisArray[$custosTotaisrow['id_custo_tarefa']] = ['servico' => $custosTotaisrow['servico'], 'custof' => $custosTotaisrow['custo_fornecedor'], 'custov' => $custosTotaisrow['custo_venda']];
}
$arraycompleto['custos'] = $custosTotaisArray;



echo json_encode($arraycompleto);
       
?>

