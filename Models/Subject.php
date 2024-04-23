<?php
//include_once (dirname(__DIR__)."/connect/connect.php");
$ServerHost = "localhost";
$userName = "root";
$password = "";
$dbName = "fci_db";


class Subject{
    public static function afterSection($teacher_id,$subject_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";


        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE subject SET session_attented = 1 WHERE teacher_id = $teacher_id AND id = $subject_id";
        $sql2= "UPDATE subject SET session_token = NULL WHERE teacher_id = $teacher_id AND id = $subject_id";
        // echo $sql;
        $con->query($sql);
        $con->query($sql2);
        
    }
    
        public static function checkToken($token,$teacher_id,$subject_id){
            $ServerHost = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "fci_db";


        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT if(session_token='$token',1,0) As 'exsit' FROM subject WHERE teacher_id = $teacher_id AND id=$subject_id";
        // echo $sql;

        $data = $con->query($sql)->fetch_assoc();

        if ($con->query($sql)->fetch_assoc()['exsit'])
            return 1;
        else
            return 0;
    }
    
        public static function AddToken($token,$teacher_id,$subject_id){
            $ServerHost = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE subject SET session_token='$token' WHERE id = $subject_id AND teacher_id = $teacher_id";
        $con->query($sql);
    }

    
        public static function selectToken(){
            $ServerHost = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT * FROM subject WHERE session_token IS NOT NULL";
        return $con->query($sql)->fetch_all();
    }
    
            public static function selectSubject($subject){
                $ServerHost = "localhost";
                $userName = "root";
                $password = "";
                $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT name FROM subject WHERE id=$subject";
        return $con->query($sql)->fetch_assoc();
    }
}