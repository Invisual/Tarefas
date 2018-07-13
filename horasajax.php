<?php
    //Conectando ao banco de dados
    require_once ('utils/Autoloader.php');
    //session_start();
    
    
    if (empty($myControlPanel)) {
    
        try {
    
        $myControlPanel = new classes_ControlPanel();
    
        $myControlPanel->setMyDb(classes_DbManager::ob());
    
        $myDbManager = $myControlPanel->getMyDb();
    
    
    
        }
    
    
        catch (Exception $e) {
    
            echo $e->getMessage();
            die();
        }
    
    
    }


    $idtarefa = $_POST['tarefa'];




    
    $obj = new classes_DbManager ();
    $dado = $obj-> horasAjax($idtarefa);


    
  
    while($resultado= $dado->fetch(PDO::FETCH_ASSOC)){
        $vetor[] = array_map(null, $resultado); 
    }    
    
    //Passando vetor em forma de json
    echo json_encode($vetor);
    
?>