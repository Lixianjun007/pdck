<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/15
 * Time: 15:14
 */

namespace app\admin\model;


use think\Model;

class SendMsg extends Model
{
    protected $table = 'send_msg';

    protected $resultSetType = 'collection';

    public function _getNow(){
        return date('Y-m-d H:i:s');
    }

    /**
     * 添加短信
     * @param $name
     * @param $phone
     * @param $number
     * @param $date
     * @author lixianjun
     * @return false|int
     * Date: 2019/4/15
     * Time: 15:33
     */
    public function addData($name, $phone, $number, $date, $city = 1)
    {
        $data = [
            'city_id'    => $city,
            'name'       => $name,
            'phone'      => $phone,
            'number'     => $number,
            'date'       => $date,
            'created_at' => $this->_getNow(),
        ];
        return $this->save($data);
    }

    /**
     * 更新发送短信记录
     * @param $id
     * @author lixianjun
     * @return false|int
     * Date: 2019/4/15
     * Time: 15:33
     */
    public function postData($id)
    {
        $data = [
            'id'      => $id,
            'is_post' => 1,
            'post_date' => $this->_getNow(),
        ];
        return $this->isUpdate(true)->save($data);
    }

    public function getDataLists($params){
        $resutl = $this->where(1)->order('id desc')->paginate(10);
        return $resutl;
    }


}