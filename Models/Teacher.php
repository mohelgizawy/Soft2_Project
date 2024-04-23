<?php
//include_once (dirname(__DIR__)."/connect/connect.php");
$ServerHost = "localhost";
$userName = "root";
$password = "";
$dbName = "fci_db";


class Teacher{
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
        $queury = "SELECT * FROM teachers WHERE email ='$email'";

        $data = $con->query($queury)->fetch_assoc();
        return $data;
    }

    public static function selectByToken($token){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "SELECT * FROM teachers WHERE teacher_token ='$token'";

        $data = $con->query($queury)->fetch_assoc();
        return $data;
    }
    
        public static function CheckPassword($id,$new){
            $ServerHost = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT IF(password=$new,1,0) as result FROM teachers WHERE id=$id";
        return $con->query($sql)->fetch_assoc()['result'];
        
    }
    
     public static function updateProfile($id, $array){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $queury = "UPDATE teachers SET ";
        foreach ($array as $key => $value){
            $queury = $queury ."$key = '$value' ";
        }
        $queury = $queury . "WHERE id = $id";
        // echo $queury;
        $con->query($queury);
        
     }


}