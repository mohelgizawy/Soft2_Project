<?php
include_once('./connect/connect.php');
$hidden_url =$_SERVER['REQUEST_URI'];
if (isset($_COOKIE['id'])){
    $_SESSION['id'] = base64_decode($_COOKIE['id']);
    $_SESSION['role'] = base64_decode($_COOKIE['role']);
}
$userId = $_SESSION['id'];
if (!isset($_SESSION['id'])) header('location:/login.php');
else if ($_SESSION['role']!='student')
    header('location:/login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./css/student/Qr.css">

    <link rel="stylesheet" href="./css/student/header.css">
    <link rel="stylesheet" href="./css/student/slider.css">
    <link rel="stylesheet" href="./css/student/container.css">
    <!-- font awsome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Token-student</title>
    <link rel="icon" href="/favicon.ico">

        <style>
        *{
            font-family:Arial;
        }
    </style>
</head>

<body>    
    <div class="slider">
        <div class="top">
            <h3>FCI</h3>
            <ul class="links">
                <li><a href="./homeWithbutton_student.php">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li><a href="./leaderboard_student.php">
                        <i class="fa-brands fa-slack"></i></i>
                        <span>Leader Board</span>
                    </a>
                </li>
                <li class="active"><a href="./token_student.php">
                        <i class="fa-solid fa-key"></i>
                        <span>Token</span>
                    </a>
                </li>
                <li><a href="./profile_student.php">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="logout">
            <p>
                <form method="POST" action="./Request.php">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <?php  
                    $hidden_url = $_SERVER['REQUEST_URI']?>
                    <input type="hidden" name="from" value = "logout">
                    <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">
                    <button style ="background: none; border: none;color: red;cursor: pointer;" type="submit">Logout</button>
                </form>
            </p>
            </div>
    </div>        
    <?php 
        $studentId = $_SESSION['id'];
        $sql = "SELECT * FROM student WHERE id=$studentId";
        $studentInfo = $con->query($sql)->fetch_assoc();

    ?>
    <div class="nav">
        <h1>Token</h1>
        <?php
            if ($studentInfo['image']){
                echo "<img src='./memberPhotos/".$studentInfo['image']."' alt=''>";
            }else {
                echo "<img src='./image/portfolio-1.jpg' alt=''>";
            }
        ?>    </div>
    <div class="container">
        <div class="image-token" style="height:280px">

            <?php

            if (isset($_GET['noInst'])){
                echo "<span style='color: #FF0000;display: block;margin: 7px 0px'>".$_GET['noInst']."</span>";
            }else if (isset($_GET['okadd'])){
                echo "<span style='color: green;margin: 7px 0px'>".$_GET['okadd']."</span>";
            }
            $hidden_url = $_SERVER['REQUEST_URI'];
            $studentId = $_SESSION['id'];
            if (isset($_GET['teacher_token'])){
                $token =$_GET['teacher_token'];
                $sql = "SELECT t.id,s.* FROM teachers t INNER JOIN subject s ON t.id= s.teacher_id WHERE t.teacher_token = '$token' AND s.id NOT IN (select subject_id from student_with_subject total where student_id = $studentId)";
                $subjects = $con->query($sql)->fetch_all();
                echo "<form action='./Request.php' METHOD='POST' style='height: fit-content;'>
                       <input type='hidden' name='hidden_url' value = '$hidden_url'>
                       <input type='hidden' name='student_id' value = '$studentId'>
                       <input  type='text' placeholder='Enter the Token of teacher' name = 'teacher_token' value='".$_GET['teacher_token']."'>
                       <label for='subject' style='color: gray'>Choose subjects</label>
                       <select style='margin: 10px 0px' name='subject[]' multiple>";
                foreach ($subjects as $subject){
                        echo "<option value='".$subject[1]."'>".$subject[2]." - time ".$subject[7]." - ".$subject[8]."</option>";
                    }
                    echo "</select>";
                echo "<button type='submit'>Join</button></form>";
            }else {
                echo "<form action='./token_student.php' METHOD='GET' style='height: 50px;'>
                       <input  type='text' placeholder='Enter the Token of teacher' name = 'teacher_token'>
                       <button type='submit'>
                            Get subjects
                       </button>
                       </form>";
            }


            ?>



        </div>
    </div>
</body>
<script src="./js/student/script.js"></script>

</html>