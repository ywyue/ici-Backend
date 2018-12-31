<?php

namespace Ici;

use PHPUnit\Runner\Exception;

class ChangeAvatar extends PageBase {

    function run($userPhone, $userName, $files) {
        $permitted = $this->checkPermission($userPhone, $userName);
        if ($permitted) {
            throw new Exception("账户不存在，没有权限更换头像");
        }


        if (!$this->validFiles($files)) {
            throw new Exception("文件上传错误，请检查后在上传");
        }

        unlink("../user/" . $userName . "/" . $userPhone . ".png");
        move_uploaded_file($_FILES["file"]["tmp_name"], "../user/" . $userName . "/" . $userPhone . ".png");
        $this->formatResponse();
    }

    /**
     * @param $userName
     * @param $userPhone
     * @return boolean
     */
    function checkPermission($userName, $userPhone) {
        $conn = \DbConn::getConn();
        $statement = "UPDATE user SET user_name = '$userName' where user_phone='$userPhone'";
        $ret = $conn->query($statement);

        if ($ret == false) {
            return false;
        }

        return true;
    }

    function checkParam() {
    }

    function formatResponse() {
        return [
            'errno' => 0,
            'msg' => 'success',
            'data' => []
        ];
    }

    /**
     * 检查文件是否符合要求
     * @param $files
     * @return bool
     */
    private function validFiles($files) {
        $fileType = $files['file']['type'];
        $fileSize = $files['file']['size'];
        $acceptFileType = ['image/gif', 'image/jpeg', 'image/pjpeg', 'png/pjpeg'];
        if (in_array($fileType, $acceptFileType) && $fileSize < 20000000) {
            $fileError = $files['file']['error'];
            if ($fileError > 0) {
                throw new Exception("文件上传错误！");
            }
            return true;
        }
        return false;
    }

}

