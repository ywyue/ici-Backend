<?php
    header("Content-type:text/html;charset=utf-8");
    require_once "config.php";
    $connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD) or die ("connection MySQL failed!");
    $db_select = mysqli_select_db($connection,$DBNAME);
    
    $poi_id = $_GET['poi_id'];
    
    $str = "SELECT board.board_id,board.is_null FROM board WHERE board.poi_id = $poi_id ORDER BY board.board_id";
    $result = mysqli_query($connection,$str) or die ("query failed! "+mysql_error);
    @$rows = mysqli_num_rows($result);
    $res['board_status'] = array();
    for($i=0;$i<$rows;$i++)
    {
        $sql_arr = mysqli_fetch_assoc($result);
        
        
        $board_id = $sql_arr['board_id'];
        $is_null = $sql_arr['is_null'];
        
        $board_status['id'] = $board_id;
        $board_status['status'] = $is_null;
        array_push($res['board_status'],$board_status);

    }
    echo json_encode($res);
    mysqli_close($connection);
