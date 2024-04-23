<?php
include_once('./connect/connect.php');
$sql = "update subject set session_attended = 0";
$con->query($sql);



