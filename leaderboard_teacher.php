<?php
require ('./connect/connect.php');
if (isset($_COOKIE['id'])){
    $_SESSION['id'] = base64_decode($_COOKIE['id']);
    $_SESSION['role'] = base64_decode($_COOKIE['role']);
}
if (!isset($_SESSION['id'])) header('location:/login.php');
else if ($_SESSION['role']!='instructor' && $_SESSION['role']!='doctor')
    header('location:/login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/teacher/leaderboard.css">
    <link rel="stylesheet" href="./css/teacher/overlay.css">

    <link rel="stylesheet" href="./css/teacher/header.css">
    <link rel="stylesheet" href="./css/teacher/slider.css">
    <link rel="stylesheet" href="./css/teacher/container.css">
    <!-- font awsome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>LeaderBoard</title>
            <link rel="icon" href="/favicon.ico">

        <style>
        *{
            font-family:Arial;
        }
    </style>
</head>

<body>
    <div class="overlay-comment" style="display: none;">
        <div class="box-comment">
            <div class="text">
                <div class="title">
                    <h3>Rate this teacher</h3>
                    <p>Give us your true rate based on overall performance for this teacher</p>
                </div>
                <div class="icon-rate">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="rate-star">
                <div class="star">
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
            </div>
            <hr>
            <form action="">
                <div class="texterea">
                    <label for="">Comment</label>
                    <textarea placeholder="Tell us more about the teacher"></textarea>
                </div>
                <input type="hidden" name="rate" value="0">
                <input type="hidden" name="teacherName" value="">
                <input type="hidden" name="teacherType" value="">
                <button class="btn-rete-comment">Add</button>
            </form>
        </div>
    </div>
    <div class="slider">
        <div class="top">
            <h3>FCI</h3>
            <ul class="links">
                <li><a href="./homeWithbutton_teacher.php">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="active"><a href="./leaderboard_teacher.php">
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
        <h1>Leader Board</h1>
        <?php
            if ($teacherInfo['image']){
                echo "<img src='./memberPhotos/".$teacherInfo['image']."' alt=''>";
            }else {
                echo "<img src='./image/portfolio-1.jpg' alt=''>";
            }
        ?> 
        </div>
    <div class="container">
            <div class="middle">
                <div class="filter">
                    <ul>
                        <li class="active doctors">Doctors</li>
                        <li class="engineers">Engineers</li>
                    </ul>
                </div>
                <div class="rate">
                    <div class="global-row doctor">
                        <div class="row">
                                <div class="image-rate">
                                    <h1 class="first">1</h1>
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Doctor1 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row doctor">
                        <div class="row">
                                <div class="image-rate">
                                    <h1 class="two">2</h1>
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Doctor2 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row doctor">
                        <div class="row">
                                <div class="image-rate">
                                    <h1 class="three">3</h1>
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Doctor3 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row doctor">
                        <div class="row">
                                <div class="image-rate">
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Doctor4 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row doctor">
                        <div class="row">
                                <div class="image-rate">
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Doctor5 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row engineer">
                        <div class="row">
                                <div class="image-rate">
                                    <h1 class="first">1</h1>
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Engineer1 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row engineer">
                        <div class="row">
                                <div class="image-rate">
                                    <h1 class="two">2</h1>
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Engineer2 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row engineer">
                        <div class="row">
                                <div class="image-rate">
                                    <h1 class="three">3</h1>
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Engineer3 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row engineer">
                        <div class="row">
                                <div class="image-rate">
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Engineer4 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
                    <div class="global-row engineer">
                        <div class="row">
                                <div class="image-rate">
                                    <img src="./image/portfolio-1.jpg" alt="">
                                    <div class="name-doc">
                                        <h3>Engineer5 Name</h3>
                                        <h6>Subject</h6>
                                    </div>
                                </div>
                                <h2 class="Add-votes">Add Votes</h2>
                        </div>
                            <div class="comment">
                                <h3>comment <i class="fa-solid fa-arrow-down"></i></h3>
                            </div>
                    </div>
            </div>
        </div>
    </div>
    <script src="./js/teacher/leaderboard.js"></script>
</body>
</html>