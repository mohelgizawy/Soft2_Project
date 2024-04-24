<?php
class Like {

    public static function AddUserLike($instId, $studId,$liker){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "INSERT INTO likes (likerId,stud_id,inst_id) values ($liker,$studId,$instId)";
        $con->query($sql);
    }


    public static function GetlikerRecord($instId, $studId,$liker){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT * FROM likes WHERE likerId = $liker AND stud_id = $studId AND inst_id = $instId";
        return $con->query($sql);
    }

    public static function DeleteLiker($instId, $studId,$liker){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "DELETE FROM likes WHERE likerId = $liker AND stud_id = $studId AND inst_id = $instId";
        $con->query($sql);
    }
}