<?php

header("Access-Control-Allow-Origin: *");
 $con = mysqli_connect("localhost","pg22933","16dbEDCFJd","pg22933_tarefas") or die ("could not connect database");
 mysqli_set_charset( $con, 'utf8');

?>