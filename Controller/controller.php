<?php
//include_once (dirname(__DIR__).'/Models/Models.php');
//include_once (dirname(__DIR__).'/Models/Message.php');
//include_once (dirname(__DIR__).'/Models/stud_with_ist.php');
//include_once (dirname(__DIR__).'/Models/like.php');
include_once (dirname(__DIR__).'/Models/Student.php');
include_once (dirname(__DIR__).'/Models/Teacher.php');
include_once (dirname(__DIR__).'/Models/Subject.php');
include_once (dirname(__DIR__) . '/Models/Student_with_subject.php');
include_once (dirname(__DIR__) . '/Models/Download_pdf_attendance.php');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try{
    include_once (dirname(__DIR__).'/connect/connect.php');

}catch (Exception $e){

}

require (dirname(__DIR__)."/library/tcpdf.php");

//include_once ('Models/Models.php');
//include_once ('Models/Message.php');
//include_once ('Models/stud_with_ist.php');
//include_once ('Models/like.php');
//require ("fpdf/fpdf.php");
//require ("vendor/autoload.php");

//use chillerlan\QRCode\QRCode;
//use chillerlan\QRCode\QROptions;





class controller {

//    protected static int $checkTime =0;

//    public static function getHome (){
//        header('location:/home.php');
//        exit;
//    }
//
//    public static function getinstractorHome (){
//        header('location:/instractorHome.php');
//        exit;
//    }
//
//    public static function getLoginPage(){
//        header('location:/login.php');
//        exit;
//    }
//
//    public static function getSignupPage(){
//        header('location:/signup.php');
//        exit;
//    }
//
//    public static function getAdminHome (){
//        header('location:/adminhome.php');
//        exit;
//    }

//    public static function SignupFun($request, $file){
//
//        // process the inputs info
//         $academicMail = $request['member_email'];
//         $memberName = $request['member_name'];
//         $password = $request['member_password'];
//         $department = $request['department'];
//
//
//        // vaild name
//        if ($memberName == ""){
//            header('location:/signup.php?vaildname=Must enter your name');
//            exit();
//        }
//
//        // vaild email
//        $academicMail = filter_var($academicMail,FILTER_SANITIZE_EMAIL);
//
//        // validation of password
//        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,}$/m", $password)){
//            header('location:/signup.php?passwrong=Password should contain lower,upper,numbers,special characture [#@$%] and at least 8 length');
//            exit();
//        }
//
//        $password = hash("md5", $password);
//
//
//      // academic photo process
//        if (!isset($file['check_id'])){
//            header('location:/signup.php?acphoto=No photo chosen');
//            exit();
//        }else
//            $academicphoto = self::savephoto($file['check_id'],"checkAcademicphoto");
//
//        // personal image process
//        if (!$file['member_image']['size']==0)
//            $profileImage = self::savephoto($file['member_image'],"membersphoto");
//        else
//            $profileImage = "avatar.png";
//
//       // access the database
//        $dataArray = [
//            "name" => "$memberName",
//            "academicphoto" => $academicphoto,
//            "department" => $department,
//            "email" => $academicMail,
//            "password" => $password,
//            "profileimage" => $profileImage
//
//        ];
//        // echo "hello";
//        Member::insert($dataArray);
//        header('location:/login.php');
//        exit();
//    }

    public static function SigninFun($request){
//
        if (Subject::selectToken()){
            header('location:./attendedError.php');
            exit();
        }else {

                $email = $request['member_email'];
                $password = $request['member_password'];
        //        echo $email . " " . $password;

                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $request ['member_email']=$email;
        //
        ////        $ArayData = null;
        ///
                if (isset($request['im_teacher'])){
                    echo "hello";
                    $ArayData = Teacher::select($request);
                }else {
                    echo "good";
                    $ArayData = Student::select($request);
                }



                if (!$ArayData)
                {
                    $_SESSION['loginerror'] = "no such email and password";
                    header('location:./login.php');
                    exit();
                }

        //        echo $password;
                if ($ArayData['password'] == hash("md5", $password)){
                    if ($ArayData['stage']){
                        setcookie("id",base64_encode($ArayData['id']),time()+(86400 * 7), '/');
                        setcookie("role",base64_encode("student"),time()+(86400 * 7), '/');
                        $_SESSION['id'] = $ArayData['id'];
                        $_SESSION['role'] = "student";
                        unset($_SESSION['loginerror']);
                        unset($_SESSION['cannotlogin']);
                        header('location:./homeWithbutton_student.php');
                        exit();
                    } elseif ($ArayData['role']=='instructor'|| $ArayData['role']=='doctor'){

                          setcookie("id",base64_encode($ArayData['id']),time()+(86400 * 7), '/');
                          setcookie("role",base64_encode($ArayData['role']),time()+(86400 * 7), '/');
                          $_SESSION['id'] = $ArayData['id'];
                        $_SESSION['role'] = $ArayData['role'];
                        unset($_SESSION['loginerror']);
                        unset($_SESSION['cannotlogin']);
                        header('location:./homeWithbutton_teacher.php');
                        exit();
                    }
        //            else{
        //                setcookie("id",$ArayData['id'],time()+(86400 * 7), '/');            //  the admin process
        //                setcookie("role",$ArayData['role'],time()+(86400 * 7), '/');
        //                $_SESSION['id'] = $ArayData['id'];
        //                $_SESSION['role'] = $ArayData['role'];
        //                unset($_SESSION['loginerror']);
        //                unset($_SESSION['cannotlogin']);
        //                header('location:/home.php');
        //                exit();
        //            }
                }
                else{
                    $_SESSION['loginerror'] = "no such email and password";
                    header('location:./login.php');
                    exit();
                }
        }
    }

    public static function logout(){
        if ($_COOKIE['role'] == "student"){
                $Data = (array)stud_with_ist::GetIpForCheckLog($_COOKIE['id']);
                $NewDataArray = array_merge(...$Data);
                $there_ip = null;
                foreach($NewDataArray as $key => $val){
                    if($val!=NULL){
                        $there_ip = "ok";
                        break;
                    }
                }
                if (!$there_ip){
                        unset($_COOKIE['id']);
                        unset($_COOKIE['role']);
                        unset($_SESSION['id']);
                        unset($_SESSION['role']);
                        unset($_SESSION['logout']);
                        unset($_SESSION['cannotlogin']);
                        unset($_SESSION['userLike']);
                        unset($_SESSION['attendClicked']);
                        

                        setcookie('id', '', -1, '/'); 
                        setcookie('role', '', -1, '/'); 
                        //        session_destroy();
                        header("location:/login.php");
                        exit();
                }else {
                        header("location:/home.php");
                        exit();
                }
        } else {
        unset($_COOKIE['id']);
        unset($_COOKIE['role']);
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        unset($_SESSION['logout']);
        unset($_SESSION['cannotlogin']);
        unset($_SESSION['userLike']);
        unset($_SESSION['attendClicked']);
        setcookie('id', '', -1, '/'); 
        setcookie('role', '', -1, '/'); 


//        session_destroy();
        header("location:/login.php");
        exit();
        }
        
    }

    public static function removeLogout($url){
        unset($_SESSION['logout']);
        header("location:$url");
        exit();
    }

    public static function ChooseTeacher($array){
        $teacherId = Teacher::selectByToken($array['teacher_token'])['id'];
        if (!$teacherId){
            header('location:./token_student.php?noInst= Token is invalid');
            exit();
        }
        foreach ($array['subject'] as $item){
            Student_with_subject::insert($item,$teacherId,$array['student_id']);
        }
        header('location:./token_student.php?okadd= Successfully Added');
        exit();
    }

    private static function GenerateCode(){
        $Probabilities = "0123456789ABCDEFGHIJKLMNOPQRSTWYZXV";
        $max = mb_strlen($Probabilities,"8bit");
        $token = "";
        for ($i =0; $i <= 6; $i++){
            $token.=$Probabilities[random_int(0,$max)];
        }
        return $token;
    }

    public static function AttendSection($arr){
        if (isset($_SESSION['attendClicked'])){
            unset($_SESSION['attendClicked']);
            // Student_with_subject::afterSection($arr['teacher_id'],$arr['subject_id']);
            Subject::afterSection($arr['teacher_id'],$arr['subject_id']);
            Download_pdf_attendance::insert($arr['teacher_id'],$arr['subject_id']);
            header('location:./homeWithbutton_teacher.php');
            exit();
        }
        $token = self::GenerateCode();
        Subject::AddToken($token,$arr['teacher_id'],$arr['subject_id']);
        $url = "./TheQr_teacher.php?teacher_id=".$arr['teacher_id']."&tokenKey=".$token."&subject_id=".$arr['subject_id'];
        $_SESSION['attendClicked'] = 1 ;
        header('location:'.$url);
        exit();
    }


    public static function studentAtteddingProcess($arr){
        // date_default_timezone_set('Africa/Cairo');
        // self::$checkTime = 1;
        // $time = date("g:i a", strtotime( date("H:i:s P")));
        // if (((time() > strtotime('9:25 pm') && time() < strtotime('9:27 pm'))||
        //     (time() > strtotime('1:00 pm') && time() < strtotime('1:05 pm'))||
        //     (time() > strtotime('3:00 pm') && time() < strtotime('3:05 pm')))) {
        //     Member::RemoveTokens();
        //     stud_with_ist::UpdateAttendance();
        //     $url = "/Attend.php?instId=".$arr['instId']."&Error=Time Out";
        //     header('location:'.$url);
        //     exit();
        // }
        
        // print_r($arr['email']);
        if (isset($arr['email'])){
            $studentId = Student::selectStudent($arr['email']);
            // echo $studentId;
    //        echo $studentId['id'];
            if (!$studentId){
                $url = "./attendToken_student.php?subject_id=".$arr['subject_id']."&teacher_id=".$arr['teacher_id']."&Error=You're Not Registered yet&register=1";
                header('location:'.$url);
                exit();
            }
            // // print_r($arr);
            if (!Student_with_subject::CheckStudentWithTeacher($studentId['id'],$arr['teacher_id'])){
                $url = "./attendToken_student.php?subject_id=".$arr['subject_id']."&teacher_id=".$arr['teacher_id']."&Error=You're Not With This Instructor";
                header('location:'.$url);
                exit();
            }
    
            if (!Subject::checkToken($arr['Token'],$arr['teacher_id'],$arr['subject_id'])){
                $url = "./attendToken_student.php?subject_id=".$arr['subject_id']."&teacher_id=".$arr['teacher_id']."&Error=Invalid Token";
                header('location:'.$url);
                exit();
            }
            Student_with_subject::updateConfirmAttendStudent($studentId['id'],$arr['teacher_id'],$arr['subject_id']);
            $url = "./attendToken_student.php?subject_id=".$arr['subject_id']."&teacher_id=".$arr['teacher_id']."&success=You Successfully Attend";
            header('location:'.$url);
            exit();
        }else {
            $url = "./attendToken_student.php?subject_id=".$arr['subject_id']."&teacher_id=".$arr['teacher_id']."&Error=You've Not logined in this browser yet";
            header('location:'.$url);
            exit();
        }

    }
    
    public static function downloadSheet($array){
        
            $subject = Subject::selectSubject($array['subject_id']);
            $students = Student_with_subject::selectStudentAttendace($array['teacher_id'],$array['subject_id']);
            // print_r($array['teacher_id']." ".$array['subject_id']);
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
            $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
            $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
            $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
            $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
            $activeWorksheet->setCellValue('A1', $subject['name']);
            
            date_default_timezone_set('Africa/Cairo');
            $date = date('Y-m-d');

            $activeWorksheet->setCellValue('A1', $subject['name']);
            $activeWorksheet->setCellValue('A1', $date);


            $counter = 1;
            foreach($students as $student){
                // print_r($student);
                $activeWorksheet->setCellValue('B'.$counter, $student[1]);
                $activeWorksheet->setCellValue('C'.$counter, $student[2]);
                $activeWorksheet->setCellValue('D'.$counter, $student[7]);
                $counter++;
            }
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename=' . $subject['name'].".xls");
            ob_end_clean();
            
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            header('location:./homeWithbutton_teacher.php');
            exit();
            

    }
    
    
    private static function savephoto ($photo, $directory,$url){
        $academicphoto = $photo['name'];

        $academicphotoExtension = explode(".",$academicphoto);
        $academicphotoExtension = array_pop($academicphotoExtension);

        $extentions = ["png", "jpeg", "jpg","PNG","JPG","JPEG"];

        if (!in_array($academicphotoExtension, $extentions)){
            header('location:'.$url.'?error=Not correct extension [png", "jpeg", "jpg","PNG","JPG","JPEG"]');
            exit();
        }

        $academicphotoNewName = time().".".$academicphotoExtension;
        move_uploaded_file($photo['tmp_name'],dirname(__DIR__)."/$directory/".$academicphotoNewName);

        return $academicphotoNewName;
    }

    
    
        private static function changeProfile($arr,$file,$member,$url){
        $dataSet = [];


        $memberPassword=null;
        $imageName = null;
        
        // print_r($arr);

        if ($arr['current_password']!=""){
            if ($arr['new_password']==""){
                        header("location:$url?error=Enter the new password");
                        exit();
            }
            if ($member=='student'){
                if (Student::CheckPassword($arr['student_id'],hash("md5",$arr['current_password']))) {
                    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,}$/m", $arr['new_password'])){
                        header("location:$url?error=Password should contain lower,upper,numbers,special characture [#@$%] and at least 8 length");
                        exit();
                    }
                    
                    $dataSet['password'] = hash("md5", $arr['new_password']);
                }
                else{
                        header("Location:$url?error=Your old password doesn't match");
                        exit();
                }
            }else {
                if (Teacher::CheckPassword($arr['student_id'],hash("md5",$arr['current_password']))) {
                    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,}$/m", $arr['new_password'])){
                        header("location:$url?error=Password should contain lower,upper,numbers,special characture [#@$%] and at least 8 length");
                        exit();
                    }
                    
                    $dataSet['password'] = hash("md5", $arr['new_password']);
                }else{
                        header("Location:$url?error=Your old password doesn't match");
                        exit();
                }
            }

        }



        // print_r(!$file['image']['name']==0);
        if (!$file['image']['name']==0){
            $imageName = self::savephoto($file['image'],"memberPhotos",$url);
            $dataSet['image'] = $imageName;

        }

        // print_r($dataSet);
        if ($url=='/profile_student.php'){
            Student::updateProfile($arr['student_id'],$dataSet);
        }else {
            Teacher::updateProfile($arr['student_id'],$dataSet);
        }
        header("Location:".$url."?success=Successfully updated");
        exit();
    }
    
     public static function changeProfile_student($arr,$file,$url){
        // print_r($arr);
        if ($file['image']['name']==0 && $arr['current_password']==""){
            header('location:/profile_student.php?error=Enter the data first');
            exit();
        }
         self::changeProfile($arr,$file,"student","/profile_student.php");
         header('location:/profile_student.php');
         exit();
        
     }
     
          public static function changeProfile_teacher($arr,$file,$url){
        // print_r($file);
                if ($file['image']['name']==0 && $arr['current_password']==""){
            header('location:/profile_student.php?error=Enter the data first');
            exit();
        }
         self::changeProfile($arr,$file,"teacher","/profile_teacher.php");
         
         header('location:/profile_teacher.php');
         exit();
        
     }
     
     
     public static function fogetPassword($array){
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                // //to view proper logging details for success and error messages
                // // $mail->SMTPDebug = 1;
                $mail->Host = 'cofateamofficial@gmail.com';  //gmail SMTP server
                $mail->Username = 'cofateamofficial@gmail.com';   //email
                $mail->Password = 'cofa20##20##';   //16 character obtained from app password created
                $mail->Port = 465;                    //SMTP port
                $mail->SMTPSecure = "ssl";
                
                
                // //sender information
                $mail->setFrom($array['email'], $array['name']);
                
                // //receiver address and name
                $mail->addAddress('cofateamofficial@gmail.com', 'FCI TEAM');
                
                
                // // Add cc or bcc   
                // // $mail->addCC('email@mail.com');  
                // // $mail->addBCC('user@mail.com');  
                
                
                
                $mail->isHTML(true);
                
                $mail->Subject = 'Forget Password';
                $mail->Body    = "<h4> I want to change the password of my account </h4>
                <b>Thank you so Much</b>
                     <p> This is a tutorial to guide you on PHPMailer integration</p>";
                
                // // Send mail   
                if (!$mail->send()) {
                    echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message has been sent.';
                }
                
                // $mail->smtpClose();
                // header('location:/forgetPassword.php');
                // exit();

     }
    
    
    
    
    
    
    
    
    
    

    // modern here
    public static function addUser($userid,$image){
        Member::update($userid);
        $url = "/checkAcademicphoto/".$image;
        unlink($url);
        header('location:/adminhome.php');
        exit();
    }

    public static function removeUser($userid) {
        Member::remove($userid);
        header('location:/adminhome.php');
        exit();
    }

//    public static function checkBadComments($comment){
//
//        $curl = curl_init();
//
//curl_setopt_array($curl, array(
//    CURLOPT_URL => 'https://api.moderatecontent.com/moderate/?',
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_ENCODING => '',
//    CURLOPT_MAXREDIRS => 10,
//    CURLOPT_TIMEOUT => 0,
//    CURLOPT_FOLLOWLOCATION => true,
//    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST => 'POST',
//    CURLOPT_POSTFIELDS => array(
//        'key' => 'a4720ea7b574b7ef54e414e86a5ef411',
//        'base64' => 'true',
//        'url' => "https://www.moderatecontent.com/txt/$comment",
//        'msg' => "$comment"
//    ),
//));
//
//$response = curl_exec($curl);
//
//curl_close($curl);
//
//        print_r($checkComment = json_decode($response,true));
//
////        if ($checkComment['is-bad']==1) {
////            return 1;
////        }
//
//        return 0;
//    }

    public static function post($array){
        $message = $array['comment'];
        $arrData = [
            "inst_id" => $array['inst_id'],
            "stud_id" => $array['student_id'],
            "message" => "$message",

        ];
        if (isset($array['showName'])){
            $arrData = array_merge($arrData,["anonymous"=> 1]);
        }
        $date = date("Y-m-d");
        $arrData = array_merge($arrData,["date" => "$date"]);
        $url = "/comments.php?instructorId=".$array['inst_id'];
//        if (controller::checkBadComments($message)){
////            header('location:'.$url."?you enter bad words");
////            exit();
//            echo "bad";
//        }else {
//            echo "good";
//        }
        Message::insert($arrData);
        header('location:'.$url);
        exit();
    }

    public static function addInstractor($array){                      // Session issues
        echo $inst_id = Member::checkInst($array['TokenInst'])['id'];
        if (!$inst_id){
            header('location:/home.php?noInst= Token is invalid');
            exit();
        }
        $Data = ['stud_id'=>$_SESSION['id'],'inst_id' => $inst_id];
        try{
            stud_with_ist::insert($Data);
        }catch (mysqli_sql_exception $e){
            header('location:/home.php?noInst= You Already with this instructor');
            exit();
        }


        header('location:/home.php?okadd= Successfully Added');
        exit();
    }

    public static function addCommentAccept($arr){
        Message::updateOk($arr['userid'], $arr['instid']);
        header('location:/adminhome.php');
        exit();
    }

    public static function remCommentAccept($arr){
        Message::removeMessage($arr['userid'], $arr['instid']);
        header('location:/adminhome.php');
        exit();
    }

    public static function addLike($arr){
        $likedBfore = Like::GetlikerRecord($arr['inst_id'],$arr['stud_id'],$arr['likerId']);
       print_r($likedBfore);

        if ($likedBfore->num_rows!=0){
            Message::removeLike($arr['inst_id'],$arr['stud_id']);
            Like::DeleteLiker($arr['inst_id'],$arr['stud_id'],$arr['likerId']);
        }else {
            Message::addLike($arr['inst_id'],$arr['stud_id']);
            Like::AddUserLike($arr['inst_id'],$arr['stud_id'],$arr['likerId']);
        }
        $url = "/comments.php?instructorId=".$arr['inst_id'];
        header('location:'.$url);
        exit();
    }

    public static function DeleteInstFromProfile($arr){
        stud_with_ist::removeInst($arr['inst_id']);
        $url = "/profile.php?memberId=".$arr['urlId'];
        header('location:'.$url);
        exit();

    }


    public static function DeleteAcount($id){
        Member::remove($id);
        $url = "/adminhome.php";
        header('location:'.$url);
        exit();
    }




    public static function Attend($arr){
        $token = self::GenerateCode();
        $ip = $_SERVER['REMOTE_ADDR'];
        Member::AddToken($token,$arr['inst_id'],$ip);
        $url = "/CreateQr.php?instId=".$arr['inst_id']."&tokenKey=".$token;
        $_SESSION['attendClicked'] = 1 ;
        header('location:'.$url);
        exit();
    }

    public static function studentAttendOk($arr){
        // date_default_timezone_set('Africa/Cairo');
        // self::$checkTime = 1;
        // $time = date("g:i a", strtotime( date("H:i:s P")));
        // if (((time() > strtotime('9:25 pm') && time() < strtotime('9:27 pm'))||
        //     (time() > strtotime('1:00 pm') && time() < strtotime('1:05 pm'))||
        //     (time() > strtotime('3:00 pm') && time() < strtotime('3:05 pm')))) {
        //     Member::RemoveTokens();
        //     stud_with_ist::UpdateAttendance();
        //     $url = "/Attend.php?instId=".$arr['instId']."&Error=Time Out";
        //     header('location:'.$url);
        //     exit();
        // }


        if (!Member::selectStudent($arr['email'])){
            $url = "/Attend.php?instId=".$arr['instId']."&Error=You're Not Registered yet&register=1";
            header('location:'.$url);
            exit();
        }
        $studentId = Member::selectStudent($arr['email'])['id'];
        if (!stud_with_ist::CheckStudentWithInst($studentId,$arr['instId'])){
            $url = "/Attend.php?instId=".$arr['instId']."&Error=You're Not With This Instructor";
            header('location:'.$url);
            exit();
        }

        if (!stud_with_ist::checkToken($arr['token_key'],$arr['instId'])){
            $url = "/Attend.php?instId=".$arr['instId']."&Error=Invalid Token";
            header('location:'.$url);
            exit();
        }
        stud_with_ist::updateConfirmAttendStudent($studentId,$arr['instId']);
        $url = "/Attend.php?instId=".$arr['instId']."&success=You Successfully Attend";
        header('location:'.$url);
        exit();
    }

    public static function createPdfForAllStudents($array){
        $students = stud_with_ist::SelectAttendEndTerm($array['instId']);
        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetTitle("Students Attendance");
        $pdf->Image('imageSite/pdflogo.png', 10, 10, -300);
        $pdf->Ln(45);
        $pdf->SetFont("Arial",'B',20);
        $pdf->Cell(15,10,"Student Attendance",1,1);

        $pdf->SetFont("Arial",'',13);
        $pdf->Cell(20,10,"Date: ". date("d-m-Y"));
        $pdf->SetFont("Arial",'',13);
        $pdf->Ln(15);


        $pdf->Cell(60,20,'Student Name');
        $pdf->Cell(65,20,'Student Email');
        $pdf->Cell(40,20,'Notes');
        $pdf->Cell(40,20,'DaysOfAttend');


        $pdf->Ln(15);
        $pdf->SetFont("Arial",'',9);

        foreach ($students as $item){
            $pdf->Cell(60,10,"$item[0]");
            $pdf->Cell(65,10,"$item[1]");
            $pdf->Cell(65,10,"");
            $pdf->Cell(65,10,"$item[2]");

            $pdf->Ln(7);
        }

        $pdf->Output();
    }

    public static function createPdf($array){
        unset($_SESSION['attendClicked']);
        Member::RemoveTokens($array['inst_id']);
        stud_with_ist::UpdateAttendance($array['inst_id']);
        $students = stud_with_ist::SelectAttend($array['inst_id']);
        $pdf = new TCPDF('p', 'mm', 'A4',true,'UTF-8',false);
        $pdf->AddPage();
        $pdf->SetTitle("Students Attendance");
        $pdf->Image('imageSite/pdflogo.png', 1, 12, 50,50);
        $pdf->Ln(45);
        $pdf->SetFont("times",'B',20);
        $pdf->Cell(15,10,"Students Attendance",1,1);

        $pdf->SetFont("times",'',13);
        $pdf->Cell(20,10,"Date: ". date("d-m-Y"));
        $pdf->SetFont("times",'',13);
        $pdf->Ln(15);


        $pdf->Cell(60,20,'Student Name');
        $pdf->Cell(65,20,'Student Email');
        $pdf->Cell(40,20,'Notes');
        $pdf->Cell(40,20,'DaysOfAttend');


        $pdf->Ln(15);
        $pdf->SetFont("freeserif",'',9);

        foreach ($students as $item){
            $pdf->Cell(60,10,"$item[0]");
            $pdf->Cell(65,10,"$item[1]");
            $pdf->Cell(65,10,"");
            $pdf->Cell(65,10,"$item[2]");

            $pdf->Ln(7);
        }

        $pdf->Output();

    }

    public static function Voting($arr){
        $checkVoted = stud_with_ist::votedBefore($arr['inst_id'], $arr['stud_id'])['voted'];
        if (!$checkVoted){
            $exist = stud_with_ist::checkVoting($arr['inst_id'], $arr['stud_id']);
            if ($exist){
                Member::votePoint($arr['inst_id'],$arr['stud_id']);
                stud_with_ist::votedUp($arr['inst_id'],$arr['stud_id']);
                 if (strlen($arr['hidden_url_temp'])>34){
                     header('location:'.$arr['hidden_url_temp'].'&voted_to_the_instUpto'.$arr['inst_id']);
                     exit();
                 }else {
                     header('location:'.$arr['hidden_url_temp'].'?voted_to_the_instUpto'.$arr['inst_id']);
                     exit();
                 }
            }
        }else {
            Member::votePointDown($arr['inst_id'],$arr['stud_id']);
            stud_with_ist::votedDown($arr['inst_id'],$arr['stud_id']);
            // $parsed = parse_url($arr['hidden_url_temp']);
            // $query = $parsed['query'];
            // parse_str($query,$paradim);
            // unset($paradim['voted_to_the_instUpt'.$arr['inst_id']]);
            // http_build_query($paradim);
            header('location:/home.php');
            exit();
        }
    }

    // public static function changeProfile($arr,$file,$url){
    //     $dataSet = [];

    //     if ($arr['name']!=""){
    //         $arr['name'] = filter_var($arr['name'], FILTER_SANITIZE_STRING);
    //         $dataSet["name"] = $arr['name'];
    //     }

    //     if ($arr['email']!=""){
    //         $arr['email'] = filter_var($arr['email'],FILTER_SANITIZE_EMAIL);
    //         $dataSet["email"] = $arr['email'];
    //     }

    //     $memberPassword=null;
    //     $imageName = null;


    //     if ($arr['comfirm_password']!=""){
    //         if (Member::CheckPassword($arr['memberId'],hash("md5",$arr['password']))) {
    //             if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,}$/m", $arr['comfirm_password'])){
    //                 header("location:$url?error=Password should contain lower,upper,numbers,special characture [#@$%] and at least 8 length");
    //                 exit();
    //             }
    //             $dataSet['password'] = hash("md5", $arr['comfirm_password']);
    //         }else{
    //                 header("Location:$url?error=Your old password doesn't match");
    //                 exit();
    //             }
    //     }



    //     if (!$file['photo_member']['name']==0){
    //         $imageName = self::savephoto($file['photo_member'],"membersphoto");
    //         $dataSet['profileImage'] = $imageName;

    //     }

    //     print_r($dataSet);
    //     Member::updateProfile($arr['memberId'],$dataSet);
    //     header("Location:$url");
    //     exit();
    // }
}