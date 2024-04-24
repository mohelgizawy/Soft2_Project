<?php
include_once('connect/connect.php');
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
    <!-- <link rel="stylesheet" href="css/profile.css"> -->
    <link rel="stylesheet" href="./css/student/QrTeather.css">
    <!-- <link rel="stylesheet" href="./css/Qr.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Qr</title>
            <link rel="icon" href="/favicon.ico">

</head>

<body>
    <div class="content">
        <div class="slider">
            <div class="top">
                <h3>FCI</h3>
                <ul class="links">
                    <li class="active"><a href="./homeWithbutton_student.php">
                            <i class="fa-solid fa-house"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fa-brands fa-slack"></i></i>
                            <span>leaderboard</span>
                        </a>
                    </li>
                    <li><a href="/subject_student.php">
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
            </p>            </div>
        </div>
        <div class="content-txt">
            <div class="nav">
                <h1>Profile</h1>
                <img src="./image/portfolio-1.jpg" alt="">
            </div>

            <!-- start the take the token-->
            <div class="image-token">
                <div class="qr">
                    <img src="./image/istockphoto-828088276-612x612.jpg" alt="">
                </div>
                <form action="">
                    <input type="text" placeholder="XXXXX" disabled>
                    <div class="Start-attend">Start Attending Session</div>
                </form>
            </div>
        </div>
    </div>

</body>
<script src="./js/student/script.js"></script>
<script src="./js/student/Qr.js"></script>
</html>