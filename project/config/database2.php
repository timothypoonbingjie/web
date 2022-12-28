<?php
// used to connect to the database
$host = "sql109.epizy.com";
$db_name = "epiz_33245138_eshop";
$user_name = "epiz_33245138";
$pass_word = "G3rbOKaZJLUa";
$mysqli = new mysqli($host, $user_name, $pass_word,$db_name);
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $user_name, $pass_word);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
}  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
?>
