<?php
    header("Content-type:text/html;charset=utf-8");
    require_once "config.php";
    //连接数据库
    $connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD);
    $db_select = mysqli_select_db($connection,$DBNAME);
    $action = $_GET['action'];     //用来区分是登录还是注册
    $user_phone = $_GET['user_phone'];   //GET方法方便用于调试
    $user_pwd = $_GET['user_pwd'];
    switch ($action) {
        case "login":
            $str = "select * from user where user_phone='$user_phone' and user_pwd='$user_pwd'";
            $result = mysqli_query($connection,$str);
            @$rows = mysqli_num_rows($result);
            if($rows) {
                $loginFlag = "1";   //登录成功
            }
            else {
                $loginFlag = "0";   //登录失败
            }
            $returnArr = array("loginFlag" => $loginFlag);
            echo json_encode($returnArr);    //输出json格式
            break;
            
        case "regist":
            $str1 = "select * from user where user_phone='$user_phone'";
            $result = mysqli_query($connection,$str1);
            @$rows = mysqli_num_rows($result);
            if($rows) {
                $registFlag = "3";   //注册失败（已存在该手机号）
            }
            else {
                $str2 = "INSERT INTO user (user_phone,user_pwd,user_image) values ('$user_phone','$user_pwd',concat('http://120.77.40.30/user/','$user_phone','/','$user_phone','.png'))";
                $result = mysqli_query($connection,$str2);
                if($result) {
                    $registFlag = "1";  //注册成功
                    mkdir ("../user/".$user_phone,0777,true);
                    chmod("../user/".$user_phone,0777);
                    copy("../moren.png","../user/".$user_phone."/".$user_phone.".png");
                }
                else {
                    $registFlag = "0";  //注册失败
                }
            }
            $returnArr = array("registFlag" => $registFlag);
            echo json_encode($returnArr);
            break;
            
        default :
            echo "登录方式错误";
            return false;
            break;
    }
    mysqli_close($connection);
    ?>
