
<?php
session_start();
include_once ('/Controller/controller.php');
$serverRequest = $_SERVER['REQUEST_URI'];

switch ($serverRequest) {
case '/home':
    controller::getHome();
break;
    case '/login':
    controller::getLoginPage();
break;
    case '/signup':
    controller::getSignupPage();
break;
    case '/adminhome':
        controller::getAdminHome();
        break;
    case '/instractorhome':
        controller::getinstractorHome();


}

