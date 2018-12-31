<?php
/**
 * Created by PhpStorm.
 * User: pengjian05
 * Date: 2018/11/25
 * Time: 16:47
 */

namespace Ici;
use PHPUnit\Runner\Exception;

abstract class PageBase {
    /**
     * 子类处理逻辑必须要实现的四个方法：
     *  1. 参数合法性校验
     *  2. 账户权限校验
     *  3. 业务逻辑处理
     *  4. 返回参数组装
     * @var array
     */
    private $methodsNeedImplement = array(
        'checkParam',
        'checkPermission',
        'run',
        'formatResponse'
    );


    public function __construct() {
        foreach ($this->methodsNeedImplement as $methodName) {
            if (!method_exists($this, $methodName)) {
                throw new Exception("method " . $methodName . " not exists", -1);
            }
        }
    }



}