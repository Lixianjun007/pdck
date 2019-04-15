<?php
/**
 * @Created by NetBeans.
 * @author  lixianjun
 * @date    2019-1-11 14:16:23
 */
 namespace app\index\controller;
use app\index\Common;

class Kingso extends Common {
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
											        
												    
}
