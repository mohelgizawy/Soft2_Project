<?php
include_once ('./connect/connect.php');
if (isset($_COOKIE['id'])){
    $_SESSION['id'] = base64_decode($_COOKIE['id']);
    $_SESSION['role'] = base64_decode($_COOKIE['role']);
}
if (!isset($_SESSION['id'])) header('location:/login.php');
else if ($_SESSION['role']!='instructor' && $_SESSION['role']!='doctor')
    header('location:/login.php');
                // unset($_SESSION['attendClicked']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/teacher/Qr.css">
    <link rel="stylesheet" href="./css/teacher/header.css">
    <link rel="stylesheet" href="./css/teacher/slider.css">
    <link rel="stylesheet" href="./css/teacher/container.css">
    <!-- font awsome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Token</title>
            <link rel="icon" href="/favicon.ico">

    
</head>

<body>
    <div class="slider">
        <div class="top">
            <h3>FCI</h3>
            <ul class="links">
                <li class="active"><a href="./homeWithbutton_teacher.php">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li><a href="./leaderboard_teacher.php">
                        <i class="fa-brands fa-slack"></i></i>
                        <span>Leader Board</span>
                    </a>
                </li>
                <li><a href="./profile_teacher.php">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></i>
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
        $teacherId = $_SESSION['id'];
        $sql = "SELECT * FROM teachers WHERE id=$teacherId";
        $teacherInfo = $con->query($sql)->fetch_assoc();
    ?>
    <div class="nav">
        <h1>Home</h1>
        <?php
            if ($teacherInfo['image']){
                echo "<img src='./memberPhotos/".$teacherInfo['image']."' alt=''>";
            }else {
                echo "<img src='./image/portfolio-1.jpg' alt=''>";
            }
        ?>  
        </div>
    <div class="container">
        <div class="image-token">
            <div class="qr">
                <?php
                $subject_id = $_GET['subject_id'];
                $teacher_id = $_SESSION['id'];
                ?>
                <img src="https://qrickit.com/api/qr.php?d=localhost/attendToken_student.php?subject_id=<?php echo $subject_id ?>&&teacher_id=<?php echo $teacher_id?>" alt="">
            </div>
            <form action="./Request.php" METHOD="post">
                <?php  $hidden_url = $_SERVER['REQUEST_URI']?>
                <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">
                <input type="hidden" name="subject_id" value = "<?php echo $_GET['subject_id']?>">
                <input type="hidden" name="teacher_id" value = "<?php echo $_GET['teacher_id']?>">

                <?php
                $sql = "SELECT session_token FROM subject WHERE teacher_id=".$_GET['teacher_id'] ." AND id=".$_GET['subject_id'];
                // echo $sql;
                $Token = $con->query($sql)->fetch_assoc()['session_token'];
                // echo $Token;
                    if ($Token){
                        echo "<input type='text' ' disabled value='$Token'>
                            <button class='Start-attend' style='background-color:red'> End Session</button>

                       ";
                    }else {
                        echo "<input type='text' placeholder='XXXXX' disabled>
                         <button class='Start-attend'>Start Attending Session</button>
                        ";
                    }
                ?>
                
            </form>
        </div>
    </div>
</body>
<script src="./js/teacher/script.js"></script>
<script src="./js/teacher/Qr.js"></script>
</html>