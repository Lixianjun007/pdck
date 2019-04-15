<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/15
 * Time: 14:59
 */

namespace app\admin\logic;



class SendMsg extends \app\admin\model\SendMsg
{

    public function addMsg($params){
        $result = '';
        $name = $params['name'];
        $phone = $params['phone'];
        $date = $params['date'];
        $number = $params['number'];
        $is_post = $params['post'];
        $this->addData($name, $phone, $number, $date);
        if($is_post){
            $this->postData($this->id);
        }
        return 11213;
    }

}