<?php
include_once (__DIR__.'/Models.php');


class stud_with_ist extends Member{
    public static function insert($array)
    {
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $queury = "INSERT INTO stud_with_ist (";
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

    public static function removeInst($id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "DELETE FROM stud_with_ist WHERE inst_id = $id";
        $con->query($sql);
    }



    public static function updateConfirmAttendStudent($studId, $instId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";
        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE stud_with_ist SET Student_attend = 1 WHERE inst_id = $instId AND stud_id = $studId";
        $con->query($sql);
    }

    public static function CheckStudentWithInst($studId, $instId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT * FROM stud_with_ist WHERE stud_id = $studId AND inst_id = $instId";
//        print_r($con->query($sql)->fetch_assoc());
        if (empty($con->query($sql)->fetch_assoc()))
            return 0;
        else
            return 1;
    }

    public static function checkToken($token,$instId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT if(Tokens='$token',1,0) As 'exsit' FROM members WHERE id = $instId";
        $con->query($sql)->fetch_assoc();
        if ($con->query($sql)->fetch_assoc()['exsit'])
            return 1;
        else
            return 0;
    }

    public static function SelectAttend($id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT m.name, m.email, s.DaysOfattend FROM stud_with_ist s JOIN members m ON m.id = s.stud_id WHERE inst_id = $id AND can_vote = 1";
        return $con->query($sql)->fetch_all();
    }

    public static function SelectAttendEndTerm($id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT m.name, m.email, s.DaysOfattend FROM stud_with_ist s JOIN members m ON m.id = s.stud_id WHERE inst_id = $id";
        return $con->query($sql)->fetch_all();
    }

    public static function UpdateAttendance($instid){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql2 = "UPDATE stud_with_ist SET dayAbsent = dayAbsent + 1 WHERE Student_attend = 0 AND inst_id = $instid";
        $con->query($sql2);
        $sql5 = "UPDATE stud_with_ist SET can_vote = 1 WHERE Student_attend = 1 AND inst_id = $instid";
        $con->query($sql5);
        $sql3 = "UPDATE stud_with_ist SET Student_attend = 0 AND inst_id = $instid";
        $con->query($sql3);
        $sql5 = "UPDATE stud_with_ist SET DaysOfattend=DaysOfattend+1 WHERE can_vote = 1 AND inst_id = $instid";
        $con->query($sql5);
        $sql4 = "DELETE FROM stud_with_ist WHERE dayAbsent >= 6 AND inst_id = $instid ";
        $con->query($sql4);

    }

    public static function checkVoting($inst_id, $stud_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT can_vote FROM stud_with_ist WHERE inst_id = $inst_id AND stud_id = $stud_id AND can_vote = 1";
        return $con->query($sql)->fetch_assoc();
    }
    public static function votedBefore($inst_id, $stud_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT voted FROM stud_with_ist WHERE inst_id = $inst_id AND stud_id = $stud_id AND can_vote = 1";
        return $con->query($sql)->fetch_assoc();
    }
    
    public static function votedUp($inst_id, $stud_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE stud_with_ist SET voted = 1 WHERE inst_id = $inst_id AND stud_id = $stud_id AND can_vote = 1";
        $con->query($sql);

    }
    
        public static function votedDown($inst_id, $stud_id){
            $ServerHost = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE stud_with_ist SET voted = 0 WHERE inst_id = $inst_id AND stud_id = $stud_id AND can_vote = 1";
        $con->query($sql);

    }
    
    public static function GetIpForCheckLog($stud_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT ip FROM members WHERE id = ANY( SELECT inst_id FROM stud_with_ist WHERE stud_id =".$stud_id.")";
        return $con->query($sql)->fetch_all();
        
    }
    
    public static function weeklyRemove(){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE stud_with_ist SET can_vote = 0, voted = 0";
        $con->query($sql);
        
    }
}