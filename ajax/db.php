<?php

header("Access-Control-Allow-Origin: *");
 $con = mysqli_connect("localhost","root","","tarefas") or die ("could not connect database");
 mysqli_set_charset( $con, 'utf8');

?>