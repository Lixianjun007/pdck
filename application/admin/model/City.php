<?php
/**
 * @author     lxj
 * @date       2018-05-15 10:06:31
 * @filename   City
 */
namespace app\admin\model;

use think\Model;
//use think\Db;

class City extends Model {

    protected $resultSetType = 'collection';
    protected $table = 'city';

    public function getcityInfo($id = false, $cityName = false, $cityPy = false) {
        
    }
    
    public function getcityIdByPY($citypy){
        $result = $this->where(['cityPy' => $citypy])->column('id');
        return $result[0];
    }

    public function getCityName($id){
        return $this->where(['id' => $id])->cache(true, 300)->find();
    }

}
