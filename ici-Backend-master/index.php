<?php
/**
 * Created by PhpStorm.
 * User: pengjian05
 * Date: 2018/11/25
 * Time: 11:05
 */

namespace Ici;
header("Content-type:text/html;charset=utf-8");

require 'vendor/autoload.php';

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;


try {
    $app = new App();
    $app->get('/hello/world', function (Request $req, Response $res, $args = []) {
        return $res->withStatus(200)->write('good for you');
    });

    $app->get('change_userinfo', function (Request $req, Response $res, $args = []) {
        $files = $req->getUploadedFiles();
        $userName = $req->getParam('user_name');
        $userPhone = $req->getParam('user_phone');
        $changeAvatar = new ChangeAvatar();
        $result = $changeAvatar->run($userPhone, $userName, $files);
        $res->withStatus(200)->write(json_encode($result, JSON_UNESCAPED_UNICODE));
    });
    $app->run();
} catch (\Exception $e) {
    echo json_encode([
                         'errno' => $e->getCode(),
                         'msg'   => $e->getMessage(),
                         'data'  => []
                     ]);
}