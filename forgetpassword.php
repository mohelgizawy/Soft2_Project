<?php

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
        <link rel="icon" href="/favicon.ico">

    <title>ِAddToken</title>
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

        </div>
        <div class="logout">
        </div>
    </div>        

    <div class="container">    
        <div class="content-txt">
            <!-- start the avatar -->
            <div class="box" style="overflow: scroll">
                <form action="./Request.php" method="POST">
                    <div class="height" style="overflow: scroll">
                        <div class="name" >
                            <label for="">Name</label>
                            <input type="text" placeholder="أسمك " name="name">
                        </div>
                        <div class="name" >
                            <label for="">Email</label>
                            <input type="text" placeholder="أدخل الإيميل الأكاديمي" name="email">
                        </div>
                        <div class="name">
                            <label for="">Your Id</label>
                            <input type="text" placeholder="أدخل الرقم القومي " name="id">
                        </div>
                        <div class="name">
                            <label for="">Your Phone</label>
                            <input type="text" placeholder="أدخل رقم واتس أب" name="phone">
                        </div>
                        <?php $hidden_url = $_SERVER['REQUEST_URI'] ?>
                        <input type="hidden" name="hidden_url" value = "<?php echo $hidden_url?>">

                    </div>
                    <button class="btn">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>