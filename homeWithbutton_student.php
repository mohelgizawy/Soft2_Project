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
    <meta charset="UTF-6">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./css/table.css"> -->
    <link rel="stylesheet" href="./css/student/table2.css?v=2">
    <link rel="stylesheet" href="./css/student/header.css">
    <link rel="stylesheet" href="./css/student/slider.css">
    <link rel="stylesheet" href="./css/student/container.css">
    <!-- font awsome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm6e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Home-Student</title>
            <link rel="icon" href="/favicon.ico">

        <style>
        *{
            font-family:Arial;
        }
    </style>
</head>

<body>

<?php
$studentId = $_SESSION['id'];
$sql = "SELECT s.*,ss.* FROM subject s JOIN student_with_subject ss ON ss.subject_id = s.id WHERE ss.student_id = $studentId";
$studentSubjects = $con->query($sql)->fetch_all();
?>
    <div class="slider">
        <div class="top">
            <h3>FCI</h3>
            <ul class="links">
                <li class="active"><a href="./homeWithbutton_student.php">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li><a href="./leaderboard_student.php">
                        <i class="fa-brands fa-slack"></i></i>
                        <span>Leader Board</span>
                    </a>
                </li>
                <li><a href="/token_student.php">
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
        <h1>Home</h1>
        <?php
            if ($studentInfo['image']){
                echo "<img src='./memberPhotos/".$studentInfo['image']."' alt=''>";
            }else {
                echo "<img src='./image/portfolio-1.jpg' alt=''>";
            }
        ?>    </div>
    <div class="container">    
        <div class="content-txt">
            <!-- start the avatar -->
            <div class="box table">
                <table style="width:100%">
                    <tr>
                        <th></th>
                        <th>9 AM:11 AM</th>
                        <th>11 AM: 1 PM</th>
                        <th>1 PM: 3 PM</th>
                    </tr>
                    <tr>
                        <td>Saturday</td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        // print_r($data);
                                        if ($data[7] === 'Sat'&&$data[6]==9){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>

                                </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Sat'&&$data[6]==11){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>

                                </div>

                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Sat'&&$data[6]==1){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Sunday</td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Sun'&&$data[6]==9){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Sun'&&$data[6]==11){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === "Sun"&&$data[6]==1){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Monday</td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Mon'&&$data[6]==9){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Mon'&&$data[6]==11){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Mon'&&$data[6]==1){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Tuesday</td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Tue'&&$data[6]==9){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Tue'&&$data[6]==11){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Tue'&&$data[6]==1){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Wednesday</td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Wed'&&$data[6]==9){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Wed'&&$data[6]==11){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Wed'&&$data[6]==1){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Thursday</td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Thu'&&$data[6]==9){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Thu'&&$data[6]==11){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="about-subject">
                                <div class="subgect-name">
                                    <?php
                                    $isThere =0;
                                    foreach ($studentSubjects as $data){
                                        if ($data[7] === 'Thu'&&$data[6]==1){
                                            if ($data[2]==0){
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: red'>Not Attended</span>";
                                            }else {
                                                echo "<h4>".$data[1]."</h4></div>";
                                                echo "<span style='color: green'>Attended</span>";
                                            }
                                            $isThere = 1;
                                        }
                                    }

                                    if ($isThere == 0){
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
<!--                <div class="class-name">-->
<!--                    <div class="top">-->
<!--                        <h3 >Current Class <span>XXXX</span></h3>-->
<!--                        <h3>Total Student <span>XXXX</span></h3>-->
<!--                        <h3 >Semester 1 in 2023</h3>-->
<!--                    </div>-->
<!--                    <form action="">-->
<!--                        <h4>Total Attend Student <span>XXXX</span></h4>-->
<!--                        <h4>Last Downloaded day <span>DD/MM/YYYY</span></h4>-->
<!--                        <button class="download"><i class="fa-solid fa-download"></i>Download Attendance Sheet</button>-->
<!--                    </form>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</body>
</html>