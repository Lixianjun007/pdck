<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/15
 * Time: 14:59
 */

namespace app\admin\logic;



use app\admin\model\City;

class SendMsg extends \app\admin\model\SendMsg
{

    public function addMsg($params){
        $result = '';
        $name = $params['name'];
        $phone = $params['phone'];
        $date = $params['date'];
        $number = $params['number'];
        $city = $params['city'];
//        $is_post = $params['post'];
        $this->addData($name, $phone, $number, $date, $city);

        return true;
    }

    public function getMsgDatas($params){
        $result = $this->getDataLists($params);
        if($result->count()){
            $cityModel = new City();
            foreach ($result as $k => $v){
                $v['city'] = $cityModel->getCityName($v['city_id'])->city_name;
            }
        }

        return $result;
    }

}