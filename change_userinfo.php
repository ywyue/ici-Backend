<?php
    require_once "config.php";
    $connection = mysqli_connect($DBHOST,$DBUSER,$DBPWD);
    $db_select = mysqli_select_db($connection,$DBNAME);
    $user_phone = $_GET['user_phone'];
    $user_name = $_GET['user_name'];
    

    $str1 = "UPDATE user SET user_name = '$user_name' where user_phone='$user_phone'";
    $result1 = mysqli_query($connection,$str1);

  
    
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
            
            unlink("../user/".$user_phone."/". $user_phone.".png");
            move_uploaded_file($_FILES["file"]["tmp_name"],"../user/".$user_phone."/". $user_phone.".png");
        }
    }
    else
    {
        echo "Invalid file";
    }
    
    mysqli_close($connection);
    ?>
