<?php
/**
 * @author     lxj
 * @date       2018-04-24 03:10:43
 * @filename   Postcar
 */
namespace app\admin\controller;

use app\admin\Common;
//use app\admin\model\Admin;
use app\admin\model\Goods;
use app\admin\model\City;
use \app\admin\model\Customer;
use \think\Request;

class Postcar extends Common {

    protected $cities;

    public function _initialize() {
        $this->_checkLogin();
        $this->cities = config('city');
    }

    public function index() {
        $start = Request::instance()->param('start');
        if (!array_key_exists($start, $this->cities)) {
            $this->redirect('admin/index/login');
        }
        $items  = 10;             //每页10条
        $order  = 'updatedTime';
        $status = Goods::STATUS[2];
        $Goods  = new Goods();
        $City   = new City();
        $cityid = $City->getcityIdByPY($start);
        $list   = $Goods->getList($items, $cityid, $status, $order);
        if ($lists  = $list->toArray()) {
            $page = $list->render();
            foreach ($lists['data'] as $k => $v) {
                $lists['data'][$k]['createdTime'] = date("Y-m-d H:i:s", $v['createdTime']);
                $lists['data'][$k]['paymethod']   = Goods::PAYMETHOD[$v['paymethod']];
            }

            // 模板变量赋值
            $this->assign('data', $lists);
            $this->assign('page', $page);
        }

        $this->assign('start', $start);
        $this->assign('title', $this->cities[$start] . '发车');

        return $this->fetch('index');
    }
    
//    public function postToCar(){
//        
//        $goods_id = Request::instance()->param('id');
//        $operate_uid = $this->userInfo['id'];
//        $Goods       = new Goods();
//        $result      = ['code' => 0, 'data' => 'failed'];
//        if ($goods_id && $operate_uid) {
//            $tmp = $Goods->isExists($goods_id);
//            if ($tmp && $tmp['status'] != 3) {
//                $Goods->update(['id' => $goods_id, 'operator_uid' => $operate_uid, 'status' => 3, 'updatedTime' => time()]);
//                $result = ['code' => 200, 'data' => 'success'];
//            }
//        }
//        return $result;
//        
//    }
}
