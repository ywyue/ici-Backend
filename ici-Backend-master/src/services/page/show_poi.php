<?php
header("Content-type:text/html;charset=utf-8");
require_once "config.php";
$connection = mysqli_connect($DBHOST, $DBUSER, $DBPWD) or die ("connection MySQL failed!");
$kyh = 0;
$db_select = mysqli_select_db($connection, $DBNAME);


$self_lat = $_GET['self_lat'];  //前端返回当前位置的纬度

function rad($d) {
    return $d * 3.1415926535898 / 180.0;
}

/**
 * /计算两个经纬度之间的距离，单位为km
 * @param $lat1
 * @param $lng1
 * @param $lat2
 * @param $lng2
 * @return float|int
 */
function GetDistance($lat1, $lng1, $lat2, $lng2) {
    $EARTH_RADIUS = 6378.137;
    $radLat1 = rad($lat1);
    //echo $radLat1;
    $radLat2 = rad($lat2);
    $a = $radLat1 - $radLat2;
    $b = rad($lng1) - rad($lng2);
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) +
                       cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $s = $s * $EARTH_RADIUS;
    $s = round($s * 10000) / 10000;
    return $s;
}

$str = "select * from poi";
$result = mysqli_query($connection, $str) or die ("query failed! " + mysql_error);
@$rows = mysqli_num_rows($result);
$res['poi'] = array();
for ($i = 0; $i < $rows; $i++) {
    $sql_arr = mysqli_fetch_assoc($result);
    if (GetDistance($self_lat, $self_lng, $sql_arr['poi_lat'], $sql_arr['poi_lng']) < 1000)  //返回距当前位置1.9km内的poi点的信息
    {
        $id = $sql_arr['poi_id'];
        $lng = $sql_arr['poi_lng'];
        $lat = $sql_arr['poi_lat'];
        $name = $sql_arr['poi_name'];
        $radius = $sql_arr['poi_radius'];
        //  echo "$id&nbsp$lng&nbsp$lat&nbsp$radius&nbsp$name";
        //  $returnArr = array("poi_id" => $id,"lng" => $lng,"lat" => $lat,"name" => $name,"radius" => $radius);
        //  echo json_encode($returnArr);    //输出json格式
        $poi['id'] = $id;
        $poi['lng'] = $lng;
        $poi['lat'] = $lat;
        $poi['name'] = $name;
        $poi['radius'] = $radius;
        array_push($res['poi'], $poi);
    }
}

for ($j = 0; $j < count($res['poi']); $j++) {
    $id = $res['poi'][$j]['id'];
    $str2 = "select post.image_url from post where post.poi_id=$id order by post.post_id asc";
    $result2 = mysqli_query($connection, $str2) or die ("query failed! " + mysql_error);
    $sql_arr2 = mysqli_fetch_assoc($result2);
    $poi['image'] = $sql_arr2['image_url'];
    array_push($res['poi'][$j], $poi['image']);
}

echo json_encode($res);

mysqli_close($connection);
