<?php
//include_once (dirname(__DIR__)."/connect/connect.php");
$ServerHost = "localhost";
$userName = "root";
$password = "";
$dbName = "fci_db";


class Student{
    public static function insert($array){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "INSERT INTO members (";
        foreach ($array as $item => $val) {
            $queury = $queury . $item . ',';
        }
        $queury = rtrim($queury, ",");
        $queury = $queury . ") values(";
        foreach ($array as $item => $val) {
            $queury= $queury . "'".$val."'".',';
        }
        $queury = rtrim($queury, ",");
        $queury = $queury .")";

        $con->query($queury);
    }

    public static function select($array){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $email = $array['member_email'];
        $queury = "SELECT * FROM student WHERE email ='$email'";

        $data = $con->query($queury)->fetch_assoc();
        return $data;

    }

    public static function selectStudent($email){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "SELECT * FROM student WHERE email ='$email'";

        $data = $con->query($queury)->fetch_assoc();
        // print_r($data);
        return $data;
    }
    
    public static function CheckPassword($id,$new){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT IF(password='$new',1,0) As result FROM student WHERE id=$id";
        // echo $con->query($sql)->fetch_assoc()['result'];
        return $con->query($sql)->fetch_assoc()['result'];
        
    }
    
     public static function updateProfile($id, $array){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $queury = "UPDATE student SET ";
        foreach ($array as $key => $value){
            $queury = $queury ."$key = '$value' ";
        }
        $queury = $queury . "WHERE id = $id";
        echo $queury;
        $con->query($queury);
        
     }
     
}