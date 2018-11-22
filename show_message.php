<?php
header("Content-type:text/html;charset=utf-8");
require_once "config.php";
$connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD) or die ("connection MySQL failed!");
$db_select = mysqli_select_db($connection,$DBNAME);
$msg_type = $_GET['msg_type'];  
$user_id = $_GET['user_id']; 

switch ($msg_type) {
case "1"://给自己账户充值的信息
$str = "SELECT    
        recharge.recharge_time, 
        recharge.recharge_num, 
        recharge.recharge_type 
FROM 
        recharge AS recharge
WHERE
        (recharge.user_id = $user_id )
ORDER BY  
        recharge.recharge_time";

        $result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
        @$rows = mysqli_num_rows($result);
        for($i=0;$i<$rows;$i++)
        {
                $sql_arr = mysqli_fetch_assoc($result);
                    $recharge_time = $sql_arr['recharge_time'];
                    $recharge_num = $sql_arr['recharge_num'];
                    $recharge_type = $sql_arr['recharge_type'];
                    echo "$recharge_time&nbsp$recharge_num&nbsp$recharge_type<br>";
        }
        break;


case "2"://给某一个说说充值的信息
$str = "SELECT 
        recharge_to_post.post_id, 
        recharge_to_post.recharge_to_post_time, 
        recharge_to_post.recharge_to_post_num 
FROM 
        (recharge_to_post AS recharge_to_post
        INNER JOIN post AS post ON (recharge_to_post.post_id = post.post_id ))
WHERE
        (post.user_id = $user_id )
ORDER BY 
        recharge_to_post.recharge_to_post_time";

        $result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
        @$rows = mysqli_num_rows($result);
        for($i=0;$i<$rows;$i++)
        {
                    $sql_arr = mysqli_fetch_assoc($result);
                    $post_id = $sql_arr['post_id'];
                    $recharge_to_post_time = $sql_arr['recharge_to_post_time'];
                    $recharge_to_post_num = $sql_arr['recharge_to_post_num'];
                    echo "$post_id&nbsp$recharge_to_post_time&nbsp$recharge_to_post_num<br>";
        }
        break;


case "3"://某人给某人点赞的信息
$str = "SELECT 
        user.user_name,
        liked.post_id,
        liked.like_time
FROM 
        (user AS user
        INNER JOIN liked AS liked ON (liked.like_user_id = user.user_id ))
WHERE
        (liked.post_id in (SELECT 
        post.post_id
FROM 
        (user AS user
        INNER JOIN post AS post ON (post.user_id = user.user_id )) 
WHERE
        (post.user_id = $user_id)))
ORDER BY 
        liked.like_time";

        $result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
        @$rows = mysqli_num_rows($result);
        for($i=0;$i<$rows;$i++)
        {
                    $sql_arr = mysqli_fetch_assoc($result);
                    $like_user_name = $sql_arr['user_name'];
                    $post_id = $sql_arr['post_id'];
                    $like_time = $sql_arr['like_time'];
                    echo "$like_user_name&nbsp$post_id&nbsp$like_time<br>";
        }
        break;
    }
        mysqli_close($connection);
?>