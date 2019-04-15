<?php
namespace app\index\controller;

use app\index\Common;
use think\Url;

class Index extends Common {

    public function _initialize() {
//        parent::_initialize();
    }

    public function index() {

//        echo "今天是 " . date("Y/m/d") . "<br>";
//
//        echo "现在时间是 " . date("h:i:sa");
        $title = '首页';
        
        
        $this->assign('title', $title);
        return $this->fetch('index');
    }

    public function joinus() {
        $title = '加入我们';
        $this->assign('title', $title);
        return $this->fetch('joinus');
    }

    public function aboutus() {
        $title = '关于我们';
        $this->assign('title', $title);
        return $this->fetch('aboutus');
    }

}
