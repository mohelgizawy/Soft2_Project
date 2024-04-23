<?php
//include_once (dirname(__DIR__)."/connect/connect.php");
$ServerHost = "localhost";
$userName = "root";
$password = "";
$dbName = "fci_db";

class Download_pdf_attendance{
    public static function insert($teacher_id,$subject_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";


        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "insert into download_pdf_attendance (teacher_id,subject_id,time_of_attendance,date_of_attendance) value($teacher_id,$subject_id,NOW(),curdate())";
        // echo $sql;
        $con->query($sql);
    }}