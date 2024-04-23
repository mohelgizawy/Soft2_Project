<?php
require ('./connect/connect.php');
// $ip = $_SERVER['REMOTE_ADDR'];
// // echo $ip;

// $user_agent = $_SERVER['HTTP_SEC_CH_UA'];
// $ischrome=str_contains($user_agent,'Google Chrome');
// if (!$ischrome){
//         header('location:/chrome.php');
//     exit();
// }
// $parts = explode('.', $ip);
// echo "<pre>";
// // $last = array_pop($parts);
// print_r($_SERVER);
// echo "</pre>";

// $user_agent = $_SERVER['HTTP_SEC_CH_UA'];
// $ischrome=str_contains($user_agent,'Google Chrome');
// echo $ischrome;
// if (!$ischrome){
//     header('location:/chrome.php');
//     exit();
// }

// // Check if the user agent contains 'Chrome'
// $is_chrome = strpos($user_agent, 'Chrome') !== false;

// echo $is_chrome;

// echo $ip;

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
    <title>Attend Student</title>
            <link rel="icon" href="/favicon.ico">

            <style>
        *{
            font-family:Arial;
        }
    </style>
</head>

<body>
<?php
    $sql = "SELECT email FROM student WHERE id =".base64_decode($_COOKIE['id']);
    $studentEmail=$con->query($sql)->fetch_assoc()['email'];
    $hidden_url = $_SERVER['REQUEST_URI'];

    $sql ="SELECT *, t.name FROM subject s INNER JOIN teachers t ON t.id=s.teacher_id";
    // echo $sql;
    $teachers = $con->query($sql)->fetch_all();
    // print_r($teachers);


?>
    <div class="container">
        <div class="logo">FCI</div>
        <div class="image-token">
            <?php
                if (isset($_GET['Error'])){
                    $error = $_GET['Error'];
                    echo "<span style='color: #FF0000'>$error</span>";
                } else if (isset($_GET['success'])){
                    $error = $_GET['success'];
                    echo "<span style='color: green'>$error</span>";

                }
            ?>
            <form action="./Request.php" method="POST">
                <?php
                echo "<select style='border: 1px solid #000; margin: 10px 0px' name = 'teacher_id'>";
                foreach ($teachers as $teacher){
                    echo "<option value='$teacher[3]'>$teacher[10] - $teacher[1] - time $teacher[6] - $teacher[7]</option>";
                }
                ?>
                <input type="text" name = "Token" placeholder="Enter the Token">
                <input type='hidden' name='hidden_url' value = '<?php echo $hidden_url?>'>
                <input type='hidden' name='email' value = '<?php echo $studentEmail?>'>
                <input type='hidden' name='subject_id' value = '<?php echo $_GET['subject_id']?>'>
<!--                <input type='hidden' name='teacher_id' value = '--><?php //echo $_GET['teacher_id']?><!--'>-->
                <button>Attend The Session</button>
            </form>
        </div>
    </div>
</body>
<script src="./js/student/script.js"></script>

</html>