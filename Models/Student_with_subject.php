<?php
//include_once (dirname(__DIR__)."/connect/connect.php");
$ServerHost = "localhost";
$userName = "root";
$password = "";
$dbName = "fci_db";


class Student_with_subject{
    public static function insert($subject, $teacher_id, $student_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "INSERT INTO student_with_subject (subject_id,teacher_id,student_id) values ($subject, $teacher_id, $student_id)";
        // echo $sql;
        $con->query($sql);
    }



    public static function CheckStudentWithTeacher($studId, $teacherId){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";

        $con = new mysqli($ServerHost,$userName,$password,$dbName);

        $sql = "SELECT * FROM student_with_subject WHERE student_id = $studId AND teacher_id = $teacherId";
        if (empty($con->query($sql)->fetch_assoc()))
            return 0;
        else
            return 1;
    }



    public static function updateConfirmAttendStudent($studId, $teacher_id,$subject_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";


        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE student_with_subject SET weekly_attented = 1 ,number_of_attendance = number_of_attendance + 1 WHERE teacher_id = $teacher_id AND student_id = $studId AND subject_id = $subject_id";
        // echo $sql;
        $con->query($sql);
    }



    public static function afterSection($teacher_id,$subject_id){
        $ServerHost = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "fci_db";


        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "UPDATE student_with_subject SET weekly_attented = 0 WHERE teacher_id = $teacher_id AND subject_id = $subject_id";
        $con->query($sql);
    }
    
        public static function selectStudentAttendace($teacher_id,$subject_id){
            $ServerHost = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "fci_db";


        $con = new mysqli($ServerHost,$userName,$password,$dbName);
        $sql = "SELECT s.*,ss.number_of_attendance FROM student_with_subject ss JOIN student s ON s.id = ss.student_id WHERE ss.teacher_id = $teacher_id AND ss.subject_id = $subject_id AND ss.weekly_attented=1";
        // print_r($con->query($sql)->fetch_all());
        return $con->query($sql)->fetch_all();
    }


}