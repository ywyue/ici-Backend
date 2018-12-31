<?php
header("Content-type:text/html;charset=utf-8");
require_once "config.php";
$connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD) or die ("connection MySQL failed!");
$db_select = mysqli_select_db($connection,$DBNAME);

$poi_id = $_GET['poi_id']; 

$str = "SELECT 
        post.board_id,
        post.post_id,
        post.user_id, 
        post.text_url, 
        post.image_url, 
        post.video_url, 
        post.post_time_release, 
        post.post_time_remain, 
        post.post_is_pass 
FROM 
        (post AS post
        INNER JOIN poi AS poi ON (post.poi_id = poi.poi_id ))
WHERE
        (poi.poi_id = $poi_id AND 
        post.post_time_remain IS NOT NULL )
ORDER BY  
        post.board_id";
$result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
        @$rows = mysqli_num_rows($result);
        for($i=0;$i<$rows;$i++)
        {
                $sql_arr = mysqli_fetch_assoc($result);
               
                    
                    $board_id = $sql_arr['board_id'];
                    $post_id = $sql_arr['post_id'];
                    $post_text = $sql_arr['text_url'];
                    $post_image = $sql_arr['image_url'];
                    $post_video = $sql_arr['video_url'];
                    $post_time_remain = $sql_arr['post_time_remain'];
                    $post_is_pass = $sql_arr['post_is_pass'];
                    $post_time_release = $sql_arr['post_time_release'];
                    
                    echo "$board_id&nbsp$post_id&nbsp$post_text&nbsp$post_image&nbsp$post_video&nbsp$post_time_remain&nbsp$post_is_pass&nbsp$post_time_release<br>";
                
        }
        mysqli_close($connection);
?>