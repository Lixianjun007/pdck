<?php
/**
 * @author     lxj
 * @date       2018-04-09 03:43:21
 * @filename   Getgoods
 */
namespace app\index\controller;

use app\index\Common;

class Getgoods extends Common{
    
    private $title = '我要查货';


    public function _initialize() {
        parent::_initialize();
    }
    
    public function index(){
        return 'this is a test getgoods';
    }
    
}