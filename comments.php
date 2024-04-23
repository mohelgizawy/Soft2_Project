<?php
require ('connect/connect.php');
if (!isset($_SESSION['id']) && !isset($_GET['fromindex'])) header('location:/login.php'); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FCI - Comments</title>
    <link rel="shortcut icon" href="/imageSite/favicon.ico" type="image/ico" sizes="16x16">
    <link rel="stylesheet" href="/css/comment.css?v=3">
    <script src = "/js/message.js"></script>

</head>
<?php
if (isset($_SESSION['id']))
    $studentId = $_SESSION['id'];
$instId= $_GET['instructorId'];
if (isset($_SESSION['id']))
    $sql = "SELECT * FROM comments where stud_id=$studentId AND inst_id= $instId";
else
    $sql = "SELECT * FROM comments where inst_id= $instId";

  $data = $con->query($sql)->fetch_assoc();
?>
<body>

<!--<header>-->
<!--    <a href="../blades/"></a>-->
<!--</header>-->
<?php
        $hidden_url = $_SERVER['REQUEST_URI'];
        $instracturId = $_GET['instructorId'];
        if (isset($_SESSION['id'])){
            $SessionId = $_SESSION['id'];
            $sql4 = "SELECT can_vote FROM stud_with_ist where can_vote = 1 AND stud_id = $SessionId AND inst_id = $instracturId";
        } else
             $sql4 = "SELECT can_vote FROM stud_with_ist where inst_id = $instracturId";
            
          $data4 = $con->query($sql4)->fetch_assoc();

                if (!isset($_GET['fromindex'])){
                        echo '<div class = "post">';
                    if (isset($data)){
                        echo '<h3 style="width: 100%; text-align: center">You commented Here before</h3>
                             <span style="display: block; margin:auto; width: 100%;text-align: center"><a href="#mycomment">Go to your comment</a></span>';
                    }else {
                        if (!$data4 || (isset($_SESSION['role']) && ($_SESSION['role']=='instructor' || $_SESSION['role']=='admin'))){
                                echo '<form action="/Request.php" method="post" style="position: relative; display:block">';
                
                                echo '<textarea name="comment" placeholder="Type Your comment Here"></textarea>
                    
                                <button type="submit" id = "btn" class="sub">Post</button>
                                <input type="checkbox" name="showName"> Anonymous
                    
                                <input type="hidden" name="hidden_url" value = '. $hidden_url.'>
                                <input type="hidden" name="inst_id" value = '.$instracturId.'>
                                <input type="hidden" name="student_id" value = '.$SessionId.'>
                                <span style="display: block">You can comment only one time per week</span>
                                </form>
                                </div>';            
                        }
                    }
    
                }

?>

    



<!--     dommy div-->
<?php
    $isThereComments = 0;
    $instracturId = $_GET['instructorId'];
    $sql = "SELECT c.*, m.name, m.profileImage, c.likes, m.role FROM comments c JOIN members m ON c.stud_id = m.id  WhERE inst_id = $instracturId";
    $data = $con->query($sql)->fetch_all();
    if (isset($_SESSION['id'])){
        $userId = $_SESSION['id'];
        $sql1 = "SELECT * FROM likes WHERE likerId = $userId";
        $likerUser = $con->query($sql1)->fetch_all();
        $likerUser = array_merge(...$likerUser);
    }

// print_r($data);

    foreach ($data as $item){
        $isThereComments++;
// //        echo $item[0] ." " . $item[1] . " " . $userId;
// //        if($item[9]<0){
// //            $likes = 0;
// //        }else {
// //            $likes = $item[9];
// //        }


        if ($item[3]==1){ // check acceptance
//            $like = null;
//            if (in_array($item[0],$likerUser) && in_array($item[1],$likerUser) && in_array($userId,$likerUser)){
//                $like = 1;
//            }else
//                $like = 0;

//            echo $like;
            if (isset($_SESSION['id']) && $item[1]==$_SESSION['id']){
                echo "<div id = 'mycomment' class = 'comment' style='border: 1px solid #03A9F4;padding: 10px;'>";
            }else
                echo "<div class = 'comment'>";

            echo "<header>";
            if ($item[5]==1){
                echo "<img src='/membersphoto/avatar.png'>
                  <span class='name'>Anonymous</span>";
            } else {
                   echo "<img src='/membersphoto/$item[8]'>
                  <span class='name' style= ''>$item[7]</span>";
                if ($item[10] == "admin"){
                        echo "<span style = 'color:red;position:relative;top:-28px;left:45px;font-size:10px'>Admin</span>";
                }
 
            }
            echo "<span class='date'>$item[4]</span></header> 
                  <p dir ='auto'>$item[2]</p>";
                  if(isset($_SESSION['id'])&&!isset($_GET['fromindex'])){
                       echo "<form action='/Request.php' method='post'>
                            <button type='submit' style='background-color: #FFF;border: none;outline: none;cursor: pointer'>
                                <span onclick='likeChange()'  class='icon'><img  id = 'like_old' style = 'width:25px'src='/imageSite/still.png'><span style = 'position:relative; top:-6px;left:5px'>$item[6]</span></span> 
                            </button>
                            <input type='hidden' name='addLike'>
                            <input type='hidden' name='hidden_url' value = '$hidden_url'>     
                            <input type='hidden' name='stud_id' value='$item[1]'>
                            <input type='hidden' name='inst_id' value='$item[0]'>
                            <input type='hidden' name='likerId' value='$studentId'>
    
                       </form>
                      </div>";
                  }


        }
    }
    
    
    if (!$isThereComments && !$data4){
        echo "<p style = 'width:100%;height:200px;display:flex;justify-content:center;align-items:center;color:blue'>There Is No Comments Here</p>";
    }
    ?>
    
    

<!--The like add to the space in 113-->
<!--<input type='hidden' name='likerId' value='$userId'>-->
<!--<span style='position: relative;top: -5px;'>$likes likes</span>-->

<!--    <div class = "comment">-->
<!--        <header>-->
<!--            <img src="../membersphoto/avatar2.jpg" alt="">-->
<!--            <span class ="name">Mahmoud Gamal</span>-->
<!--            <span class="date">20-11-2023</span>-->
<!--        </header>-->
<!--        <p dir = "auto">والله هو بس حضرتك كنت سريع شويه المحاضره اللي فاتت</p>-->
<!--        <span class="icon"><img src="../imageSite/still.png" alt=""></span>-->
<!--    </div>-->
    <script src = "/js/likes.js"></script>
</body>
</html>