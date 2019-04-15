<?php
/**
 * @author     lxj
 * @date       2018-04-18 02:11:42
 * @filename   Admin
 */
namespace app\admin\model;

use think\Model;

class Admin extends Model {

    protected $resultSetType = 'collection';

    public function test() {
//        $a = $this->get(['userName' => 'aa'])->toArray();
//        $a = $this->where(['userName' => 'admin'])->column('id,nickName,phone');
        $a = $this->where(['status' => '1'])->paginate(1, true);
        return $a;
    }

    //根据用户名获取用户信息
    public function getByuserName($userName) {
        $result = $this->get(['userName' => $userName, 'status' => 1]);
        if ($result) {
            return $result->toArray();
        }
        return false;
    }

}
