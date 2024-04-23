<?php
$ServerHost = "localhost";
$userName = "root";
$password = "";
$dbName = "fci_db";

$con = new mysqli($ServerHost,$userName,$password,$dbName);

session_start();

?>
