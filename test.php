<?php
header("Content-type:text/html;charset=utf-8");
require_once "config.php";
$connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD) or die ("connection MySQL failed!");
$db_select = mysqli_select_db($connection,$DBNAME);

$user_id = $_GET['user_id']; 


$str = "SELECT 
        
        user.user_phone, 
        user.user_name, 
        user.user_image,
        user.user_time_remain,
        post.post_id, 
        post.text_url, 
        post.image_url, 
        post.video_url, 
        post.post_time_remain, 
        post.post_is_pass, 
        post.post_time_release,
        poi.poi_name
FROM 
        ((user AS user
        INNER JOIN post AS post ON (post.user_id = user.user_id )) INNER JOIN poi AS poi ON (poi.poi_id = post.poi_id ))
WHERE
        (user.user_id = $user_id AND 
        post.post_is_delete = 2 )
ORDER BY 
        post.post_time_release DESC";
$result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
        @$rows = mysqli_num_rows($result);
        if($rows) {  
            $loginFlag = "1";
            $loginFlag2 = "2";  //登录成功  
        }  
        else {  
            $loginFlag = "0";   //登录失败  
        }  
        $returnArr = array("loginFlag" => $loginFlag,"loginFlag2" => $loginFlag2);  
        echo json_encode($returnArr);    //输出json格式  
        
        mysqli_close($connection);
?>