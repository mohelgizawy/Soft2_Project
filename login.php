<?php
        include_once ('./connect/connect.php');

        // $sql = "SELECT * FROM subject WHERE session_token IS NOT NULL";
        // $isToken = $con->query($sql)->fetch_all();
        // if ($isToken){
        //     header('location:/attendedError.php');
        //     exit();
        // }
        
        if (isset($_COOKIE['id'])){
        if (base64_decode($_COOKIE['role'])=="student"){
            header('location:/homeWithbutton_student');
            exit();
        } else if (base64_decode($_COOKIE['role'])=="instructor"||base64_decode($_COOKIE['role'])=="doctor"||base64_decode($_COOKIE['role'])=="demonstrator"){
            header('location:/homeWithbutton_teacher.php');
            exit();
        }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- icon link  -->
        <link rel="stylesheet" href="/css/student/style.css?v=2">
    <title>Login</title>
            <link rel="icon" href="/favicon.ico">

    <style>
        *{
            font-family:Arial;
        }
    </style>
</head>
<body>
    <!-- <div id="image-loader"></div> -->
    <div class="container">
        <div class="top-left t"></div>
        <div class="bottom-left t"></div>
        <div class="top-right t"></div>
        <div class="bottom-right t"></div>
        <div class="box ">
            <div class="top">
                <h1>FCI</h1>
                <div class="welcome">
                    <p>welcome back</p><p>to your account</p>
                </div>
            </div>
            <hr>
            <form action="./Request.php" method="POST">
                <?php  $hidden_url = $_SERVER['REQUEST_URI']?>
                <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">
                <div class="email">
                    <label for="">Email</label>
                    <input  type="text" name = "member_email" placeholder="example@gmail.com" id="email-content" onkeyup="validationEmail()">
                </div>
                <!-- ahmed khalid atiya -->
                <div class="password">
                    <label  for="">Password</label>
                    <input  type="password" placeholder="Enter your password" name = "member_password">
                    <div class="forget">
                        <div class="check">
                            <input type="checkbox"  id="vertical" name = "im teacher">
                            <label for="vertical">I'm a teacher</label>
                        </div>
                        <a href="/forgetpassword.php">Forget Password ? </a>
                    </div>
                    <span style="color :red; margin:0;font-family: Arial;font-size: 18px"><?php if (isset($_SESSION['loginerror'])) echo $_SESSION['loginerror']?></span>
                </div>
                <button class="btn">Log in</button>
            </form>
        </div>
    </div>
</nav>
</body>
<script src="./js/teacher/script.js"></script>
</html>