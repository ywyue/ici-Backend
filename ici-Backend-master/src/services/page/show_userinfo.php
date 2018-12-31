<?php
header("Content-type:text/html;charset=utf-8");
require_once "config.php";
$connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD) or die ("connection MySQL failed!");
$db_select = mysqli_select_db($connection,$DBNAME);

 
$user_phone = $_GET['user_phone'];
$str = "select user.user_id from user where user_phone='$user_phone'";
$result = mysqli_query($connection,$str);
$sql_arr = mysqli_fetch_assoc($result);
$user_id = $sql_arr['user_id'];
    
$str = "SELECT 
        
        user.user_phone,
        user.user_name, 
        user.user_image,
        user.user_time_remain
    
FROM 
        (user AS user)
        
WHERE
        user.user_id = $user_id";
        //user.user_phone = $user_phone";
        $result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
        @$rows = mysqli_num_rows($result);
    


    for($i=0;$i<$rows;$i++)
        {
                    $sql_arr = mysqli_fetch_assoc($result);
                    $phone = $sql_arr['user_phone'];
                    $name = $sql_arr['user_name'];
                    $image = $sql_arr['user_image'];
                    $user_time_remain = $sql_arr['user_time_remain'];
            
            
                        //输出json格式
               //     echo json_encode($name&nbsp$phone&nbsp$image&nbsp$user_time_remain&nbsp$post_id&nbsp$post_text&nbsp$post_image&nbsp$pos//t_video&nbsp$post_time_remain&nbsp$post_is_pass&nbsp$post_time_release&nbsp$poi_name);
             //   echo json_encode($returnArr);
            
        }
    
    $return = array('phone' => $phone,'id' => $user_id,'name' => $name,'image' => $image,'time_remain' => $user_time_remain);
    echo json_encode($return);
    
    mysqli_close($connection);
?>
