<?php
/**
 * @author     lxj
 * @date       2018-04-09 03:43:07
 * @filename   Postgoods
 */
namespace app\index\controller;

use app\index\Common;

class Postgoods extends Common {

    private $title = '我要发货';

    public function _initialize() {
        parent::_initialize();
    }

    public function index() {
        return 'this is a test Postgoods';
    }

}
