<?php
/**
 * Created by PhpStorm.
 * User: pengjian05
 * Date: 2018/11/8
 * Time: 15:19
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Log {
    /**
     * @var Logger
     */
    private static $log = null;

    /**
     * 单例模式
     * @return Logger|null
     */
    public static function getInstance() {
        if (is_null(self::$log)) {
            self::$log = new Logger('logger_name');
            try {
                $streamH = new StreamHandler(".\\logs\\the.log", Logger::NOTICE);
                self::$log->pushHandler($streamH);
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
                self::$log = null;
            } catch (Exception $e) {
                echo $e->getMessage();
                self::$log = null;
            }
            return self::$log;
        } else {
            return self::$log;
        }
    }

    /**
     * 添加notice
     * @param $message
     * @return bool
     */
    public static function addNotice($message) {
        $logger = self::getInstance();
        if (!is_null($logger)) {
            $logger->notice($message);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加warn
     * @param $message
     * @return bool
     */
    public static function addWarn($message) {
        $logger = self::getInstance();
        if (!is_null($logger)) {
            $logger->warn($message);
            return true;
        } else {
            return false;
        }
    }
}