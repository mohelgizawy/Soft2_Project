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
    
    $hidden_url = $_SERVER['REQUEST_URI']?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/student/profile.css">
    <link rel="stylesheet" href="./css/student/header.css">
    <link rel="stylesheet" href="./css/student/slider.css">
    <link rel="stylesheet" href="./css/student/container.css">
    <!-- font awsome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Profile</title>
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
                <li><a href="./token_student.php">
                        <i class="fa-solid fa-key"></i>
                        <span>Token</span>
                    </a>
                </li>
                <li  class="active"><a href="./profile_student.php">
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
        $studentId = $_SESSION['id'];
        $sql = "SELECT * FROM student WHERE id=$studentId";
        $sql2 = "SELECT ss.*,s.name FROM student_with_subject ss JOIN subject s ON ss.subject_id = s.id WHERE student_id=$studentId";
        $studentInfo = $con->query($sql)->fetch_assoc();
        $studentSubjects = $con->query($sql2)->fetch_all();

        // print_r($studentInfo);
    ?>
    <div class="nav">
        <h1>Profile</h1>
        <?php
            if ($studentInfo['image']){
                echo "<img src='./memberPhotos/".$studentInfo['image']."' alt=''>";
            }else {
                echo "<img src='./image/portfolio-1.jpg' alt=''>";
            }
        ?>
    </div>
    <div class="container">    

        <div class="content-txt">
            <!-- start the avatar -->
            <div class="box">
                <form action="./Request.php" method="POST" enctype="multipart/form-data">
                    <div class="image">
                        <span class="edit-image">
                            <i class="fa-regular fa-pen-to-square"></i>
                            <input type="file" accept="image/*" name="image" style="display:none;">
                        </span>
                        <?php
                            if ($studentInfo['image']){
                                echo "<img src='./memberPhotos/".$studentInfo['image']."' alt=''>";
                            }else {
                                echo "<img src='./image/portfolio-1.jpg' alt=''>";
                            }
                        ?>   
                        </div>
                    <div class="height">
                        <div class="name">
                            <label for="">Name</label>
                            <input type="text" placeholder="Name" name ="name" value="<?php echo $studentInfo['name']?>" style="width:100%" disabled>
                        </div>
                    </div>
                    <div class="select">
                    <label for="">subject</label>
                    <select name="" id="">
                        <?php 
                        print_r($studentSubjects);
                            foreach($studentSubjects as $subject){
                                echo "<option value'$subject[5]'>$subject[7]</option>";
                            }
                        ?>
                    </select>
                    </div>
                    <div class="pass" style="margin-top: 19px;">
                        <div class="text">
                            <h4>Current password</h4>
                        </div>
                        <?php
                            if(isset($_GET['error'])){
                                $error = $_GET['error'];
                                echo "<span style ='color:red'>$error</span>";
                            }else if (isset($_GET['success'])){
                                $error = $_GET['success'];
                                echo "<span style ='color:green'>$error</span>";

                            }
                        ?>
                        <input type="password" placeholder="Type the current password" name="current_password" style="margin-top:2px">
                        <input type="password" placeholder="Type the new password" name="new_password">
                        <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">
                        <input type="hidden" name="from" value = "changeProfile">
                        <input type="hidden" name="student_id" value = "<?php echo $studentId?>">

                    </div>

                    <button class="btn" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="./js/student/script.js"></script>

</html>