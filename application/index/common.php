<?php
/**
 * @author     lxj
 * @date       2018-04-09 09:59:35
 * @filename   common
 */
namespace app\index;

use think\Controller;

class Common extends Controller {
    
    private $en = 1;

    public function _initialize() {
        return;
    }
    
    public function hello(){
        echo 'hello';
        return;
    }

}
