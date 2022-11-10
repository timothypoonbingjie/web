<?php
session_start();
if (!isset($_SESSION["Pass"])){
    header("location:login.php?Error");
}
?>