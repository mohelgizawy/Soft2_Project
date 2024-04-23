<?php
require ('./connect/connect.php');
if (isset($_COOKIE['id'])){
    $_SESSION['id'] = base64_decode($_COOKIE['id']);
    $_SESSION['role'] = base64_decode($_COOKIE['role']);
}
if (!isset($_SESSION['id'])) header('location:/login.php');
else if ($_SESSION['role']!='instructor' && $_SESSION['role']!='doctor')
    header('location:/login.php');
    
    $hidden_url = $_SERVER['REQUEST_URI']?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/teacher/profile.css">
    <link rel="stylesheet" href="./css/teacher/header.css">
    <link rel="stylesheet" href="./css/teacher/slider.css">
    <link rel="stylesheet" href="./css/teacher/container.css">
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
<body style = "overflow:scroll;padding-bottom:20px">
    <div class="slider">
        <div class="top">
            <h3>FCI</h3>
            <ul class="links">
                <li><a href="./homeWithbutton_teacher.php">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li><a href="./leaderboard_teacher.php">
                    <i class="fa-brands fa-slack"></i></i>
                    <span>Leader Board</span>
                </a>
                </li>

                <li  class="active"><a href="./profile_teacher.php">
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
            $sql2 = "SELECT * FROM subject WHERE teacher_id=$teacherId";
            // echo $sql2;
            $teacherInfo = $con->query($sql)->fetch_assoc();
            $teacherSubjects = $con->query($sql2)->fetch_all();
        ?>
    <div class="nav">
        <h1>Profile</h1>
        <?php
            if ($teacherInfo['image']){
                echo "<img src='./memberPhotos/".$teacherInfo['image']."' alt=''>";
            }else {
                echo "<img src='./image/portfolio-1.jpg' alt=''>";
            }
        ?>   
        </div>
    <div class="container">  
        <?php 
        if (isset($_GET['error'])){
            $error = $_GET['error'];
            echo "<span style='color:red'>$error</span>";
        }
    ?>
        <div class="content-txt">
            <!-- start the avatar -->
            <div class="box" style="overflow:scroll">
                <form action="./Request.php" method="POST" enctype="multipart/form-data">
                    <div class="image">
                        <span class="edit-image">
                            <i class="fa-regular fa-pen-to-square"></i>
                            <input type="file" name ="image" accept="image/*" style="display:none;">
                        </span>
                        <?php
                            if ($teacherInfo['image']){
                                echo "<img src='./memberPhotos/".$teacherInfo['image']."' alt=''>";
                            }else {
                                echo "<img src='./image/portfolio-1.jpg' alt=''>";
                            }
                        ?> 
                        </div>
                    <div class="height">
                        <div class="name">
                            <label for="">Name</label>
                            <input type="text" placeholder="Name" name ="name" value="<?php echo $teacherInfo['name']?>" style="width:100%" disabled>
                        </div>
                        <div class="token">
                            <label for="">token</label>
                            <input type="text" value="<?php echo $teacherInfo['teacher_token']?>" disabled>
                        </div>
                    </div>
                    <div class="select">
                    <label for="">subject</label>
                    <select name="" id="">
                        <?php 
                        // print_r($teacherSubjects);
                            foreach($teacherSubjects as $subject){
                                echo "<option value'$subject[0]'>$subject[1] - time $subject[6] - $subject[7]</option>";
                            }
                        ?>
                    </select>
                    </div>
                    <div class="pass" style="margin-top: 10px;">
                        <div class="text">
                            <h4>Current password</h4>
                            <!--<span>-->
                            <!--    <i class="fa-solid fa-pen-fancy"></i>-->
                            <!--    Edit-->
                            <!--</span>-->
                        </div>
                        <input type="password" placeholder="Type the current password" name="current_password" style="margin-top:2px">
                        <input type="password" placeholder="Type the new password" name="new_password">
                        <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">
                        <input type="hidden" name="from" value = "changeProfile">
                        <input type="hidden" name="student_id" value = "<?php echo $teacherId?>">
                    </div>
                    <button class="btn" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="./js/teacher/script.js"></script>

</html>