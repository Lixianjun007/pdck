<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/25
 * Time: 15:06
 */

namespace app\admin\logic;


use app\admin\model\Customer;
use app\admin\model\Order;
use think\Exception;

class OrderLogic extends Order
{

    /**
     * @param $type
     * @param $name
     * @param $number
     * @param $city_id
     * @param $date
     * @author lixianjun
     * @return Order|false|\PDOStatement|string|\think\Collection|\think\Paginator
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * Date: 2019/4/25
     * Time: 16:21
     */
    public function getLists($type, $name, $number, $city_id, $date, $pageSize)
    {

        if ($type == 1) {//type1: 未支付的订单
            $status = 1;
        } else if ($type == 2) {//type2:已支付的订单
            $status = 2;
        } else if ($type == 3) { // type3:某一天的订单
            $status = false;
        } else {
            throw new Exception('sss', 199);
        }
        $list = $this->getListsInfos($pageSize, $status, $name, $number, $city_id, $date);
        return $list;
    }

    public function saveInfo($userInfo, $name, $phone, $number, $froms, $tos, $price, $has_price, $has_pay_price,
                             $post_price, $invoicing_price, $arrears_price, $location)
    {
        $customerObj = new Customer();
        $customer_id = $customerObj->getCustomerId($name, $phone);
        $data        = [
            'customer_id'     => $customer_id,
            'number'          => $number,
            'from_city_id'    => $froms,
            'to_city_id'      => $tos,
            'price'           => $price,
            'has_price'       => $has_price,
            'has_pay_price'   => $has_pay_price,
            'post_price'      => $post_price,
            'invoicing_price' => $invoicing_price,
            'arrears_price'   => $arrears_price,
            'location'        => $location,
            'admin_id'        => $userInfo['id'],
            'created_at'      => date('Y-m-d H:i:s'),
        ];
        return $this->save($data);
    }

}