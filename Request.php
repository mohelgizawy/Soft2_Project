<?php
include_once ('./Controller/controller.php');
 $array = $_POST;
 $file = $_FILES;
if (isset($_POST['hidden_url'])) $url = $_POST['hidden_url'];
//if (isset($_GET['hidden_url'])) $url = $_GET['hidden_url'];
if (isset($_POST['acceptuser'])) $acceptuser = $_POST['acceptuser'];
if (isset($_POST['userid'])) $userid = $_POST['userid'];

$url = explode("?",$url)[0];

// print_r($url);
// echo $array['from'];
//  if(isset($_SESSION['logout'])){
//           controller::logout();

//  }
if ($url == "/login.php"){
        controller::SigninFun($array);
}

if ( isset($array['from']) && $array['from']=='logout'){
     controller::logout();
 }
 
 if ($url == "/homeWithbutton_teacher.php"  && isset($array['from']) && $array['from'] == 'download'){
     controller::downloadSheet($array);
 }
 
 
 
//  if ($url == "/adminhome.php" && isset($_SESSION['logout']) && !isset($_POST['acceptcomment']) && !isset($_POST['changeProfile'])) {
//      controller::logout();
//  }
 


// if ($url == "/instractorHome.php" && isset($_SESSION['logout']) && !isset($_POST['acceptcomment']) && !isset($_POST['changeProfile'])) {
//     controller::logout();
// }

if ($url == "/token_student.php") {
    controller::ChooseTeacher($array);
}

if ($url == "/TheQr_teacher.php"&& !isset($_POST['printPdf'])){
    controller::AttendSection($_POST);
}

if ($url == "/attendToken_student.php"){
    controller::studentAtteddingProcess($_POST);
}

if ($url == "/profile_student.php" && isset($array['from']) && $array['from'] == 'changeProfile'){
    controller::changeProfile_student($array,$file,$url);
}

if ($url == "/profile_teacher.php" && isset($array['from']) && $array['from'] == 'changeProfile'){
    controller::changeProfile_teacher($array,$file,$url);
}


if ($url == "/forgetpassword.php"){
    controller::fogetPassword($array);
}





//  if ($url =="/adminhome.php" && $_POST['acceptcomment']=='true'){
//      controller::addCommentAccept($_POST);
//  }

// if ($url =="/adminhome.php" && $_POST['acceptcomment']=='false'){
//     controller::remCommentAccept($_POST);
// }


// if (isset($_POST['acceptuser']) && $acceptuser == "true") {
//     controller::addUser($userid,$_POST['userImage']);
// }

// if (isset($_POST['acceptuser']) && $acceptuser == "false") {
//     controller::removeUser($userid);
// }

//  if (($url == "/login.php"|| $url == "/blogPost/blades/login.php" )&& isset($_SESSION['logout'])){
//      controller::removeLogout($url);
//  }

//  if ($url == "/comments.php" && !isset($_POST['addLike'])){
//      controller::post($_POST);
//  }
// if ($url == "/comments.php" && isset($_POST['addLike'])){
//     controller::addLike($_POST);
// }


// if ($url == "/home.php" &&  isset($_POST['add']) && !isset($_POST['acceptcomment'])){
//      controller::addInstractor($_POST);
//  }

// if ($url == "/home.php" &&  isset($_POST['voting'])){
//     controller::Voting($_POST);
// }

// if ($url == "/profile.php" &&  $_POST['purpose'] == 'deleteInst'){
//     controller::DeleteInstFromProfile($_POST);
// }

// if ($url == "/profile.php" &&  $_POST['purpose'] == 'deleteAccount'){
//     controller::DeleteAcount($_POST['acountId']);
// }



// if ($url == "/Attend.php"){
//     controller::studentAttendOk($_POST);
// }

// if ($url == "/printPdf.php"){
//     controller::createPdfForAllStudents($_POST);
// }


// if ($url == "/CreateQr.php"&& isset($_POST['printPdf'])){
//     controller::createPdf($_POST);
// }


// // change profile
// if (isset($_POST['changeProfile'])){
//     controller::changeProfile($_POST,$file,$url);
// }





//echo $url == "/comments.php";
// echo "hello";
//echo $url == "/instractorHome.php" && isset($_POST['changeProfile']);

//echo (isset($_SESSION['logout']));
//echo (isset($_POST['acceptcomment']));









