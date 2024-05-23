<?php

  $db_server = "localhost";
  $db_user   = "BhanuPraksh";
  $db_pass   = "Bhanu@172";
  $db_name   = "management";

  $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
  if(!$conn){
    die("Connection failed! :".mysqli_connect_error());
  }
?>
