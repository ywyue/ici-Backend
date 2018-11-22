<?php
    header("Content-type:text/html;charset=utf-8");
    require_once "config.php";
    //连接数据库
    $connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD);
    $db_select = mysqli_select_db($connection,$DBNAME);
    $poi_id = $_GET['poi_id']; 
    $user_phone = $_GET['user_phone'];
    $board_id = $_GET['pic_id'];
    $time_release = $_GET['time_release'];

    $str = "UPDATE board SET is_null = '0' where board_id='$board_id' and poi_id='$poi_id'";
    $result = mysqli_query($connection,$str);
    
    if ((($_FILES["file"]["type"] == "image/gif")
         || ($_FILES["file"]["type"] == "image/jpeg")
         || ($_FILES["file"]["type"] == "image/pjpeg")
         || ($_FILES["file"]["type"] == "png/pjpeg"))
        && ($_FILES["file"]["size"] < 20000000))
    {
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        }
        else
        {
            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
            echo "Type: " . $_FILES["file"]["type"] . "<br />";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
            
            if (file_exists("/ARmaterial/poi/poi_".$poi_id."/". $_FILES["file"]["name"]))
           
            {
            	unlink("/ARmaterial/poi/poi_".$poi_id."/". $_FILES["file"]["name"]);
            	move_uploaded_file($_FILES["file"]["tmp_name"],"/ARmaterial/poi/poi_".$poi_id."/". $_FILES["file"]["name"]);
                echo ["file"]["name"] . " already exists. ";
            }
            else
            {
                move_uploaded_file($_FILES["file"]["tmp_name"],"/ARmaterial/poi/poi_".$poi_id."/". $_FILES["file"]["name"]);
                echo "Stored in: " . "/ARmaterial/poi/poi_".$poi_id."/". $_FILES["file"]["name"];
            }
        }
    }
    else
    {
        echo "Invalid file";
    }
    
    mysqli_close($connection);
    ?>
