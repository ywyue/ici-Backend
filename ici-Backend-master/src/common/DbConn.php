<?php
/**
 * Created by PhpStorm.
 * User: pengjian05
 * Date: 2018/11/25
 * Time: 11:21
 */

class DbConn {
    /**
     * @var mysqli | null
     */
    private static $conn = null;
    /**
     * @var string
     */

    /**
     * 数据库
     * @return mysqli | null
     */
    public static function getConn() {
        if (!is_null(DbConn::$conn)) {
            return DbConn::$conn;
        } else {
            $conf = parse_ini_file('./conf/db/ici.ini');
            try {
                DbConn::$conn = new mysqli($conf['ip'], $conf['username'], $conf['password'], $conf['database'], $conf['port']);
            } catch (Exception $e) {
                Log::addNotice("数据库连接错误" . $e->getMessage());
            }

            if (DbConn::$conn->connect_errno) {
                $errMsg = DbConn::$conn->connect_error;
                Log::addNotice("数据库连接错误：" . $errMsg);
                DbConn::$conn->close();
            }
            return DbConn::$conn;
        }
    }
}