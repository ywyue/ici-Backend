<?php
    header("Content-type:text/html;charset=utf-8");
    require_once "config.php";
    $connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD) or die ("connection MySQL failed!");
    $db_select = mysqli_select_db($connection,$DBNAME);
    
    $user_phone = $_GET['user_phone'];
    $str = "SELECT
    post.post_id,
    post.user_phone,
    post.text,
    post.image_url,
    post.video_url,
    post.post_time_release,
    post.post_time_remain,
    post.post_is_pass,
    poi.poi_name
    FROM
    ((post AS post
     INNER JOIN user AS user ON (post.user_phone = user.user_phone )) INNER JOIN poi AS poi ON (post.poi_id = poi.poi_id))
    WHERE
    user.user_phone = $user_phone
    ORDER BY
    post.post_id DESC";
    $result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
    @$rows = mysqli_num_rows($result);
    $res['board_content'] = array();
    for($i=0;$i<$rows;$i++)
    {
        $sql_arr = mysqli_fetch_assoc($result);
       
        $board_content['post_id'] = $sql_arr['post_id'];
        $board_content['post_text'] = $sql_arr['text'];
        $board_content['post_image'] = $sql_arr['image_url'];
        $board_content['post_video'] = $sql_arr['video_url'];
        $board_content['post_time_remain'] = $sql_arr['post_time_remain'];
        $board_content['post_is_pass'] = $sql_arr['post_is_pass'];
        $board_content['post_time_release'] = $sql_arr['post_time_release'];
        $board_content['poi_name'] = $sql_arr['poi_name'];
        array_push($res['board_content'],$board_content);
    }
    $res2 = array('myboard' =>$res['board_content']);
    echo json_encode($res2);
    mysqli_close($connection);
    ?>

