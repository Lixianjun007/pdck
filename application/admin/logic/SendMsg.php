<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/15
 * Time: 14:59
 */

namespace app\admin\logic;



use app\admin\model\City;
use Msg\send;
use think\Db;
use think\Log;

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
//        $this->addData($name, $phone, $number, $date, $city);
        if($this->doSend($name,$phone,$number,$city)){
            $this->addData($name, $phone, $number, $date,$city,1);
        }
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


    /**
     * 发送短信函数
     * @param $name
     * @param $phone
     * @param $number
     * @param $city_id
     * @author lixianjun
     * @return bool
     * Date: 2019/4/23
     * Time: 12:28
     */
    public function doSend($name, $phone, $number, $city_id)
    {
        $obj = new send();
        if ($city_id == 1) {
            $city = '义乌';
        } else {
            $city = '上海';
        }
        $contend = "$name||$number||$city";
        $result  = $obj->sendToMsg($contend, $phone);
        $results = json_decode($result, true);
        Log::record($result);
        Log::record($contend);
        Log::save();
        if ($results['Message'] == 'OK') {
            Db::table("msg_log")->insert(['phone' => $phone, 'msg' => $contend, 'created_at' => date('Y-m-d H:i:s')]);
            return true;
        } else {
            return false;
        }
    }

}