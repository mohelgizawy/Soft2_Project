<?php
include_once (__DIR__.'/Models.php');


class Message extends Member{
    public static function insert($array)
    {
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "INSERT INTO comments (";
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
    public static function updateOk($studId, $instId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE comments SET checkAceptance = 1 WHERE inst_id = $instId AND stud_id = $studId";
        $con->query($sql);
    }

    public  static  function removeMessage($studId, $instId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "DELETE FROM comments WHERE inst_id = $instId AND stud_id = $studId";
        $con->query($sql);

    }

    public static function addLike($instId, $studId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE comments SET likes = likes + 1 WHERE inst_id = $instId AND stud_id = $studId";
        $con->query($sql);
    }

    public static function removeLike($instId, $studId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE comments SET likes = likes - 1 WHERE inst_id = $instId AND stud_id = $studId";
        $con->query($sql);
    }

}