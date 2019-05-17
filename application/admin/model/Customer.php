<?php
/**
 * @author     lxj
 * @date       2018-05-09 03:05:37
 * @filename   Customer
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Customer extends Model {

    protected $resultSetType = 'collection';
    protected $table         = 'customer';

    public function getCustomerId($name, $phone) {

        $tmp = Db::table($this->table)->where(['name' => $name, 'phone' => $phone])->field('id')->find();
        if (!$tmp) {
            $data['name']  = $name;
            $data['phone'] = $phone;
            $result        = Db::table($this->table)->insert($data, false, true);
        } else {
            $result = $tmp['id'];
        }

        return $result;
    }
    
    public function addOne($id, $is_post = true){
        if($is_post){
            $inc = 'post_count';
        }else{
            $inc = 'get_count';
        }
        Db::table($this->table)->where('id', $id)->setInc($inc);
    }


    public function checkPhoneAndUserName($phone, $name){
        $record = $this->where([
            'name' => $name,
            'phone' => $phone
        ])->find();
        if($record == null){
            $data['name']  = $name;
            $data['phone'] = $phone;
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->save($data);
        }
        return true;
    }


    public function getLists($name, $pageSize){
        if($name){
            $where = ['name' => ['like', "%$name%"]];
        }else{
            $where = 1;
        }
        $lists = $this->where($where)->order('name asc')->paginate($pageSize);
        return $lists;
    }



}
