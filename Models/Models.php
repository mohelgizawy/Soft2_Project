<?php
//include_once (dirname(__DIR__)."/connect/connect.php");
$ServerHost = "localhost";
$userName = "root";
$password = "";
$dbName = "fci_db";

$con = new mysqli($ServerHost,$userName,$password,$dbName);
class Member {


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
        $queury = "SELECT * FROM members WHERE email ='$email'";

        $data = $con->query($queury)->fetch_assoc();
        return $data;

    }

    public static function checkInst($token){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $queury = "SELECT id FROM members WHERE ownToken = '$token'";
        $data = $con->query($queury)->fetch_assoc();
        return $data;
    }

    public static function update($value){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "UPDATE members SET validCheck = 'approved' WHERE id = $value";

        $data = $con->query($queury);
    }

    public static function remove($value){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury4 = "DELETE FROM comments  WHERE inst_id = $value OR stud_id = $value";
        $queury2 = "DELETE FROM likes  WHERE inst_id = $value OR stud_id = $value";
        $queury3 = "DELETE FROM stud_with_ist  WHERE inst_id = $value OR stud_id = $value";
        $queury = "DELETE FROM members  WHERE id = $value";

        $con->query($queury3);
        $con->query($queury4);
        $con->query($queury2);
        $con->query($queury);

    }

    public static function selectStudent($email){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "SELECT * FROM members WHERE email ='$email'";

        $data = $con->query($queury)->fetch_assoc();
        return $data;

    }

    public static function AddToken($token, $instId,$ip){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE members SET Tokens = '$token' WHERE id = $instId";
        $con->query($sql);
        $sql1 = "UPDATE members SET ip = '$ip' WHERE id = $instId";
        $con->query($sql1);
    }

    public static function RemoveTokens($inst_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE members SET Tokens = null Where id = $inst_id";
        $con->query($sql);
        $sql1 = "UPDATE members SET ip = null Where id = $inst_id";
        $con->query($sql1);

    }

    public static function votePoint($inst_id,$stud_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE members SET points = points + 1 WHERE id = $inst_id";
        $con->query($sql);
        $sql = "UPDATE stud_with_ist SET voted = 1 WHERE inst_id = $inst_id AND stud_id = $stud_id AND can_vote = 1";
        $con->query($sql);
    }

    public static function votePointDown($inst_id,$stud_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE members SET points = points - 1 WHERE id = $inst_id";
        $con->query($sql);
        $sql = "UPDATE stud_with_ist SET voted = 0 WHERE inst_id = $inst_id AND stud_id = $stud_id AND can_vote = 1";
        $con->query($sql);
    }

    public static function CheckPassword($id, $oldPassword){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT password FROM members WHERE id = $id";
        $DBpassword = $con->query($sql)->fetch_assoc();
        return $DBpassword['password'] == $oldPassword;
    }

    public static function updateProfile($id, $array){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "UPDATE members SET ";
        foreach ($array as $key => $value){
            $queury = $queury ."$key = '$value' ";
        }
        $queury = $queury . "WHERE id = $id";
        echo $queury;
        $con->query($queury);
    }


}
