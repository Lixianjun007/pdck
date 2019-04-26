<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/25
 * Time: 15:06
 */

namespace app\admin\model;


use think\Model;

class Order extends Model
{

    protected $table = 'order';


    /**
     * 列表显示，带搜索条件
     * @param int $pageSize
     * @author lixianjun
     * @return Order|false|\PDOStatement|string|\think\Collection|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Date: 2019/4/25
     * Time: 16:02
     */
    public function getListsInfos($pageSize = 0,$status = false, $name = '', $number = '', $to_city_id = 0, $date = false)
    {
        $field = [
            'c.name customer_name', 'c.phone customer_phone', 'o.id', 'o.status',
            'o.number', 'o.from_city_id', 'from.city_name froms', 'o.to_city_id', 'to.city_name tos', 'o.location',
            'o.price', 'o.has_price', 'o.has_pay_price', 'o.post_price', 'o.invoicing_price',
            'o.arrears_price', 'o.admin_id', 'o.actual_price', 'o.pay_way', 'o.created_at', 'o.updated_at',
        ];
        $where = [];
        if ($name) { //姓名搜索
            $where = array_merge($where, ['c.name' => ['like', "%$name%"]]);
        }
        if ($number) { //单号搜索
            $where = array_merge($where, ['o.number' => ['like', "%$number%"]]);
        }
        if($to_city_id){//城市筛选
            $where = array_merge($where, ['o.to_city_id' => $to_city_id]);
        }
        if($date){//日期筛选
            $dateStart = $date.' 00:00:00';
            $dateEnd = $date.' 23:59:59';
            $where = array_merge($where, ['o.created_at' => ['>', $dateStart]]);
            $where = array_merge($where, ['o.created_at' => ['<', $dateEnd]]);
        }
        if( $status!== false && is_numeric($status)){
            $where = array_merge($where, ['o.status' => $status]);
        }

        $tmp = $this->alias('o')
            ->where($where)
            ->join('customer c', 'o.customer_id=c.id', 'left')
            ->join('city from', 'from.id=o.from_city_id', 'left')
            ->join('city to', 'to.id=o.to_city_id', 'left')
            ->field($field)->order('id desc');

        if ($pageSize > 0) {
            $tmp = $this->paginate($pageSize);
        } else {
            $tmp = $tmp->select();
        }
        return $tmp;
    }

    public function addInfo()
    {

    }


}