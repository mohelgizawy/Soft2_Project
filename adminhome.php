<?php
require ('connect/connect.php');
if (isset($_COOKIE['id'])){
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['role'] = $_COOKIE['role'];
}
if (!isset($_SESSION['id'])&& $_SESSION['role']!='admin') header('location:/login.php');
else if ($_SESSION['role']!='admin')
    header('location:/login.php');
    
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin-Home</title>
    <link rel="stylesheet" href="css/adminhome.css?v=5">
    <link rel="shortcut icon" href="/imageSite/favicon.ico" type="image/ico" sizes="16x16">
    <script>
        document.addEventListenner('keyup',(e)=>{
            if(e.key == 'PrintScreen'){
                navigator.clipboard.writeText('');
                alert("disabled");
            }
            alert("screenshot disabled");
        })
    </script>



<body>
</head>
    <?php
    $sql3 = "SELECT COUNT(message) AS 'MsCount' FROM comments WHERE checkAceptance = 0";
    $sql4 = "SELECT COUNT(id) AS 'JoCount' FROM members where validCheck = 'unapproved'";
    $MsCount = $con->query($sql3)->fetch_assoc();
    $JoCount = $con->query($sql4)->fetch_assoc();

    ?>
    <nav>
            <button  id = "choose_profile" onclick="profile()" style="border-top: 1px solid #525FE1;">Profile</button>
            <button id = "choose_rank" onclick="rank()">Rank</button>
            <button id = "choose_join" onclick="join()">Joins</button>
             <span class = "join-num"><?php echo$JoCount['JoCount']?></span>
            <button id = "message_click" onclick="message()">Messages</button>
            <span class = "me-num"><?php echo$MsCount['MsCount']?></span>
            <button id = "member_join" onclick="member()">Members</button>

    </nav>

        <?php
        $id = $_SESSION['id'];
        $sql3 = "SELECT * FROM members where id = '$id'";
        $Admin = $con->query($sql3)->fetch_assoc();
        ?>
        <div class = "image-name">
            <header>
                Profile Picture
            </header>
            <div class = "content-div">
                <img src="/membersphoto/<?php echo $Admin['profileImage']?>" alt="">
                <?php echo $Admin['name'] ?> <br>
                <span style="color: red"><?php echo $Admin['role'] ?></span>
                <form action="/Request.php" method="POST">
                    <input type="submit" value="LogOut">
                    <input type="hidden" value = "<?php $_SESSION['logout']="true";?>">
                    <?php  $hidden_url = $_SERVER['REQUEST_URI']?>
                    <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">
                </form>
            </div>
        </div>
        <div class="content"  id = "profile_section" style="display: block">
            <form action="/Request.php" method = 'POST' enctype="multipart/form-data">
                <?php
                $id = $_SESSION['id'];
                $sql = "SELECT * FROM members where id = $id";
                $data = $con->query($sql)->fetch_assoc();
                ?>
                <label for="name">
                    Your Name
                </label>
                <input type="text" name="name" id="name" placeholder="<?php echo$data['name']?>" class="type">
                <label for="email">
                    Your Email
                </label>
                <input type="email" name="email" id="email" placeholder="<?php echo $data['email']?>" class="type">
                <label for="password">
                    Your Password
                </label>
                <input type="password" name="password" id="password" placeholder="Type your old password" class="type">
                <label for="passwordc">
                    Confirm Password
                </label>
                <input type="password" name="comfirm_password" id="passwordc" placeholder="confirm your new password" class="type">
                <label for="photo">
                    Profile Picture
                </label>
                <span style="color: red"><?php if(isset($_GET['error'])) echo $_GET['error']?></span>
                <div class = "photo_div">
                    <input type="file" name="photo_member" id="photo" class = "photo">
                </div>
                <?php  $hidden_url = $_SERVER['REQUEST_URI']?>
                <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">
                <input type="hidden" name="memberId" value=<?php echo $id?>>
                <input type="hidden" name="changeProfile" value="chage">
                <input type="submit" value="Save" class = "Save">
            </form>
        </div>


<div class="rank"  id = "rank_section" style="display: none">
    <?php
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM members where role ='instructor' ORDER BY points DESC";
    $data = $con->query($sql)->fetch_all();

    //    $sql2 = "SELECT if(COUNT(id)=0 ,1,COUNT(id)) AS 'all' FROM members where role = 'student'";
    //    $data2 = $con->query($sql2)->fetch_assoc();

    $sql2 = "SELECT if(COUNT(can_vote)=0 ,1,COUNT(can_vote)) AS 'all' FROM stud_with_ist where can_vote = 1";
    $whoCanVote = $con->query($sql2)->fetch_assoc();
    $bigestPoint = $data[0][4];
    ?>




    <?php
    $sortedData = [];
    foreach ($data as $datum) {

        $sql3 = "SELECT if(COUNT(inst_id)=0,1,COUNT(inst_id)) AS 'all' FROM stud_with_ist where inst_id = $datum[0] AND can_vote = 1";
        $allInstructors = $con->query($sql3)->fetch_assoc();

        $sql2 = "SELECT COUNT(can_vote) AS 'voted' FROM stud_with_ist where voted = 1 AND inst_id = $datum[0]";
        $whoCanVote = $con->query($sql2)->fetch_assoc();
//    print_r($datum[4]);
        $sortedData[$datum[0]] = number_format((float)($whoCanVote['voted'] / $allInstructors['all'] * 100), 2, '.', '');
    }
    ?>
    <?php
    arsort($sortedData);
    $i = 1;
    foreach ($sortedData as $datum => $val) {
        $sql = "SELECT * FROM members where role ='instructor' AND id = $datum";
        $data = $con->query($sql)->fetch_all();
        if ($i == 1) {
            echo "
            <div style='border-bottom: 1px solid #DDD;font-family: monospace;'>
            <span style='width: 0px'> " . "<img src = '/imageSite/first.png'>" . "</span>";
        } else if ($i == 2) {
            echo "<div style='border-bottom: 1px solid #DDD;font-family: monospace;'>
            <span style='width: 0px'> " . "<img src = '/imageSite/second.png'>" . "</span>";
        } else if ($i == 3) {
            echo "<div style='border-bottom: 1px solid #DDD;font-family: monospace;'>
            <span style='width: 0px'> " . "<img src = '/imageSite/third.png'>" . "</span>";
        } else {
            echo "
            <div style='border-bottom: 1px solid #DDD;font-family: monospace;'>
            <span style='width: 0px'> " . $i . "</span>";
        }
        echo "<span  style='width: 56px;'> <img src='/membersphoto/" . $data[0][2] . "'alt=''></span>
            <span> " . $data[0][1] . "</span>
            <span> " . $data[0][3] . "</span>
            <span> " . $val."%</span>
            <span><a href='/comments.php?instructorId=$datum'><img src = '/imageSite/message.png'></a></span> ";


        echo "</div>";
        $i++;
    }

    ?>

</div>




<div class="joins" id = "join_section" style="display: none">
    <?php
    $id = $_SESSION['id'];
    $sql4 = "SELECT * FROM members where validCheck = 'unapproved'";
    $data4 = $con->query($sql4)->fetch_all();

    $number = "SELECT COUNT(id) AS 'number' FROM members where validCheck = 'unapproved'";
    $numberOfWiew = $con->query($number)->fetch_assoc();

    ?>
    <h3><?php echo $numberOfWiew['number']?> Request</h3>

    <div style="background-color: #525FE1;color: #FFF;">

        <span style='width: 149px;'>Name</span>
        <span style="width: 8px">Role</span>
        <span style="width: 255px;">Email</span>
        <span style="width: 349px;">Academic Photo</span>

    </div>

    <?php
    $i = 1;
    foreach ($data4 as $datum) {
        $function = "popupimage("."'".$datum[7]."'".")";
            echo '
            <div>
                <span style="width: 150px;"> '.$datum[1] .'</span>
                <span style="width: 70px;"> '.$datum[3] .'</span>
                <span style="width: 150px;margin-left: 80px;"> '.$datum[8] .'</span>
                <span style="width: 90px;"> '.$datum[5] .'</span>
                <span> <img onclick='."$function".' id = "academicphotozoom" src="/checkAcademicphoto/'.$datum[7] .'"></span>
               
                <form action = "/Request.php" METHOD="POST">
                    <input type="submit" value="Accept" style="background-color : forestgreen" class="acc">
                    <input type="hidden" name="acceptuser"  value ="true">
                    <input type="hidden" name="userImage" value="'.$datum[7].'">
                    <input type="hidden" name="userid"'.' value =" '. $datum[0].'" >
                </form>
                
                <form action = "/Request.php" METHOD="POST">
                    <input type="submit" value="Del" style="background-color: darkred" class="del">
                    <input type="hidden" name="acceptuser"  value ="false">
                    <input type="hidden" name="userid"'.' value =" '. $datum[0].'" >
                </form>
                    <div id = "overray" class="overlay" style="width: 97%;height: 100%;background: rgba(0,0,0,.66);position: absolute;top: 0;left: 0;display: none;"></div>
                        <div class="img-show" id = "img_show" style="width: 600px;
    height: 400px;
    background: #FFF;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    overflow: hidden;
    display: none;">
                            <span style="position: absolute;
    top: -177px;
    right: -45px;
    z-index: 99;
    cursor: pointer;" onclick="closepopup()">X</span>
                            <img id = "zoomedImg" src="/checkAcademicphoto/'.$datum[7] .'">
                    </div>
            </div>';
        $i++;
    }
    ?>
</div>









<div class="message" id = "message_section" style="display: none">
    <?php
    $id = $_SESSION['id'];
    $sql4 = "SELECT c.message, c.date, m.name, m.email,m.profileImage,c.inst_id,c.stud_id FROM comments c
        JOIN members m
        ON c.stud_id = m.id                                  
        where checkAceptance = 0";

    $data4 = $con->query($sql4)->fetch_all();
    $number = "SELECT COUNT(message) AS 'number' FROM comments where checkAceptance = 0";
    $numberOfWiew = $con->query($number)->fetch_assoc();

    ?>
    <h3><?php echo $numberOfWiew['number']?> Request</h3>

    <div style="background-color: #525FE1;color: #FFF;">

        <span style='width: 90px;'>Name</span>
        <span style="width: 90px;">image</span>
        <span style="width: 152px;">Email</span>
        <span style="width: 90px;">Date</span>
        <span style="width: 90px;">message</span>


    </div>

    <?php  $hidden_url = $_SERVER['REQUEST_URI']?>

    <?php
    $i = 1;
    foreach ($data4 as $datum) {
        echo '
            <div style="height: fit-content">
                <span style="width: 112px;"> '.$datum[2] .'</span>
                <span> <img onclick="popupimage()" id = "academicphotozoom" src="/membersphoto/'.$datum[4] .'"></span>
                <span style="width: 70px;margin-right: 38px;
    padding-left: 70px;"> '.$datum[3] .'</span>
                <span style="width: 150px"> '.$datum[1] .'</span>
                <span dir = "auto"style="width: 160px;height: fit-content;"> '.$datum[0] .'</span>
               
                <form action = "/Request.php" METHOD="POST">
                    <input type="submit" value="Accept" style="background-color : forestgreen" class="acc">
                    <input type="hidden" name="acceptcomment"  value ="true">
                    <input type="hidden" name="userid"'.' value =" '. $datum[6].'" >
                    <input type="hidden" name="instid"'.' value =" '. $datum[5].'" >
                    <input type="hidden" name="hidden_url" value = "'. $hidden_url.'">

                </form>
                
                <form action = "/Request.php" METHOD="POST">
                    <input type="submit" value="Del" style="background-color: darkred" class="del">
                    <input type="hidden" name="acceptcomment"  value ="false">
                    <input type="hidden" name="userid"'.' value =" '. $datum[6].'" >
                    <input type="hidden" name="instid"'.' value =" '. $datum[5].'" >
                    <input type="hidden" name="hidden_url" value = "'. $hidden_url.'">


                </form>
                    <div id = "overray"class="overlay" style="width: 97%;height: 100%;background: rgba(0,0,0,.66);position: absolute;top: 0;left: 0;display: none;"></div>
                        <div class="img-show" id = "img_show" style="    width: 600px;
    height: 400px;
    background: #FFF;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    overflow: hidden;
    display: none;">
                            <span style="position: absolute;
    top: -177px;
    right: -45px;
    z-index: 99;
    cursor: pointer;" onclick="closepopup()">X</span>
                            <img  src="/membersphoto/'.$datum[4] .'">
                    </div>
            </div>';
        $i++;
    }

    ?>
</div>








<div class="message" id = "member_section" style="display: none">
    <?php
    $id = $_SESSION['id'];
    $sql4 = "SELECT * FROM members WHERE role IN('instructor','doctor','student') AND validCheck = 'approved'";

    $data4 = $con->query($sql4)->fetch_all();
    $number = "SELECT COUNT(id) AS 'number' FROM members WHERE role IN('instructor','doctor') UNION SELECT COUNT(id) AS 'studentNum' FROM members WHERE role = 'student'";
    $numberOfWiew = $con->query($number)->fetch_all();

    ?>
<!--    <h3>--><?php //echo $numberOfWiew['number']?><!-- Request</h3>-->

    <div style="background-color: #525FE1;color: #FFF;">

        <span style='width: 90px;'>Name</span>
        <span style="width: 90px;">image</span>
        <span style="width: 152px;">Email</span>


    </div>

    <span STYLE="display: block;margin-left: 30px;color: #978f8f;margin-bottom: 21px;">Instructors <?php echo $numberOfWiew[0][0];?></span>
    <?php
    foreach ($data4 as $datum) {

        if ($datum[3]=='instructor' || $datum[3]=="doctor"){
            $url = "profile.php?memberId=$datum[0]";
            echo '
            <div style="height: fit-content">
            
                <span style="width: 112px;"> '.$datum[1] .'</span>
                <span> <img onclick="popupimage()" id = "academicphotozoom" src="/membersphoto/'.$datum[2] .'"></span>
                <span style="width: 70px;margin-right: 38px;
    padding-left: 70px;"> '.$datum[8] .'</span>
                <span style="width: 150px"></span>'.
                '<a href='.$url.'><img src="/imageSite/info.png">Profile</a>
                    <div id = "overray"class="overlay" style="width: 97%;height: 100%;background: rgba(0,0,0,.66);position: absolute;top: 0;left: 0;display: none;"></div>
                        <div class="img-show" id = "img_show" style="    width: 600px;
    height: 400px;
    background: #FFF;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    overflow: hidden;
    display: none;">
                            <span style="position: absolute;
    top: -177px;
    right: -45px;
    z-index: 99;
    cursor: pointer;" onclick="closepopup()">X</span>
                            <img  src="/membersphoto/'.$datum[2] .'">
                    </div>
            </div>';
        }
        $i++;
    }
    ?>


    <span STYLE="display: block;margin-left: 30px;color: #978f8f;margin-bottom: 21px;">Students <?php echo $numberOfWiew[1][0]?></span>
    <?php
    foreach ($data4 as $datum) {
        if ($datum[3]=='student'){
            $url = "profile.php?memberId=$datum[0]";
            echo '
            <div style="height: fit-content">
            
                <span style="width: 112px;"> '.$datum[1] .'</span>
                <span> <img onclick="popupimage()" id = "academicphotozoom" src="/membersphoto/'.$datum[2] .'"></span>
                <span style="width: 70px;margin-right: 38px;
    padding-left: 70px;"> '.$datum[8] .'</span>
                <span style="width: 150px"></span>'.
                    '<a href='.$url.'><img src="/imageSite/info.png">Profile</a>
                    <div id = "overray"class="overlay" style="width: 97%;height: 100%;background: rgba(0,0,0,.66);position: absolute;top: 0;left: 0;display: none;"></div>
                        <div class="img-show" id = "img_show" style="    width: 600px;
    height: 400px;
    background: #FFF;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    overflow: hidden;
    display: none;">
                            <span style="position: absolute;
    top: -177px;
    right: -45px;
    z-index: 99;
    cursor: pointer;" onclick="closepopup()">X</span>
                            <img  src="/membersphoto/'.$datum[2] .'">
                    </div>
            </div>';
        }
    }
    ?>
</div>
<script src = "/js/alter.js?v=9"></script>
</body>
</html>