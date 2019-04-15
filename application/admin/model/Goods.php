<?php
/**
 * @author     lxj
 * @date       2018-04-24 03:59:47
 * @filename   Goods
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Goods extends Model {

    protected $resultSetType = 'collection';
    protected $table         = 'goods';

    const STATUS    = [1, 0, 2, 3];  //0:已删除订单  1:订单填写完成，2:订单处理完成，3:订单已装车
    const PAYMETHOD = [1 => '现付', 2 => '到付', 3 => '月结'];

    public function getList($items, $cityid, $status, $order = 'id desc', $time = false, $getcityid = false, $getname = false) {
        $result = Db::table($this->table)->alias('a')
                ->join('customer post', 'a.post_id = post.id')
                ->join('customer get', 'a.get_id = get.id')
                ->join('city', 'a.getcity_id = city.id');
        if ($time) {
            $result = $result->whereBetween('updatedTime', [$time[0], $time[1]]);
        }
        if ($getcityid) {
            $result = $result->where(['getcity_id' => $cityid, 'status' => $status]);
        } else {
            $result = $result->where(['postcity_id' => $cityid, 'status' => $status]);
        }
        if ($getname) {
            $result = $result->where('get.name', 'like', "%" . $getname . "%");
        }

        $result = $result
//                ->where(['post_id' => $cityid, 'status' => $status])
                ->order($order)
                ->field(['a.*', 'city.cityName', 'post.name as postname', 'post.phone as postphone', 'get.name as getname', 'get.phone as getphone',])
                ->paginate($items);

//        $result = $this->where(['status' => '0'])
//                ->join('customer post', 'goods.post_id = post.id')
//                ->join('customer get', 'goods.get_id = get.id')
//                ->paginate(2);
        return $result;
    }

    /**
     * 获取当日货品编号
     * @param type $number
     * @param type $cityid
     * @return string
     */
    public function getTodayNumber($number, $cityid = 1) {
        $m          = date('m');
        $d          = date('d');
        $y          = date('Y');
        $beginToday = mktime(0, 0, 0, $m, $d, $y);
        $endToday   = mktime(0, 0, 0, $m, $d + 1, $y) - 1;

        $count = Db::table($this->table)
                ->where(['postcity_id' => $cityid])
                ->where('status', 'in', self::STATUS[2] . ',' . self::STATUS[3])
                ->whereBetween('updatedTime', [$beginToday, $endToday])
                ->order('updatedTime desc')
                ->limit(1)
                ->column('number');
        if ($count) {
            $n      = strstr($count[0], '-', true);
            $n++;
            $result = $n . '-' . $number;
        } else {
            $m      = (int) $m;
            $result = $m . $d . '1-' . $number;
        }
        return $result;
    }

    public function isExists($id) {
        $result = $this->get($id);
        if ($result) {
            return $result->toArray();
        }
        return false;
    }

    public function getOneInfo($id) {
        $result = Db::table($this->table)->alias('a')
                ->join('customer post', 'a.post_id = post.id')
                ->join('customer get', 'a.get_id = get.id')
                ->join('city getcity', 'a.getcity_id = getcity.id')
                ->join('city postcity', 'a.postcity_id = postcity.id')
                ->where(['a.id' => $id, 'a.status' => 1])
                ->limit(1)
                ->field(['a.*', 'postcity.cityPy as postcityPy', 'getcity.cityPy as getcityPy', 'post.name as postname', 'post.phone as postphone', 'get.name as getname', 'get.phone as getphone',])
                ->select();
        if ($result) {
            return $result[0];
        }
        return false;
    }

}
