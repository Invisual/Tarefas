<?php
header('Content-Type: application/json');
    include "db.php";
    
    
    $data=false;

    $pw = $_POST['pw'];
    $pagina = $_POST['pagina'];

    $q=mysqli_query($con,"SELECT pw from passwords where pagina = '$pagina'");
    mysqli_set_charset( $con, 'utf8');
        
    
    while ($row=mysqli_fetch_assoc($q)){
      $pass = $row['pw'];
      if(md5($pw) == $pass){
        $data = true;
      }
    }

    echo json_encode($data);
       
?>

