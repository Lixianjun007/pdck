<?php
/**
 * @author     lxj
 * @date       2018-04-24 03:10:59
 * @filename   Getgoods
 */
namespace app\admin\controller;

use app\admin\Common;
use app\admin\model\Admin;
use \think\Request;
use app\admin\model\Goods;
use app\admin\model\City;

class Getgoods extends Common {

    protected $cities;

    public function _initialize() {
        $this->_checkLogin();
        $this->cities = config('city');
    }

    public function index() {
        $local = Request::instance()->param('local', 'yw');
        if (!array_key_exists($local, $this->cities)) {
            $this->redirect('admin/index/login');
        }
        $date    = Request::instance()->param('month_date', false);
        $getname = Request::instance()->param('getname', false);

        if ($date == false) {
            $m    = date('m');
            $d    = date('d') - 1;
            $y    = date('Y');
            $date = $y . '-' . $m . '-' . $d;
        } else {
            list($y, $m, $d) = explode('-', $date);
        }
        $dayBegin = mktime(0, 0, 0, $m, $d, $y);
        $dayEnd   = mktime(0, 0, 0, $m, $d + 1, $y) - 1;
        $items    = 10;
        $order    = 'updatedTime';
        $status   = Goods::STATUS[3];
        $Goods    = new Goods();
        $City     = new City();
        $cityid   = $City->getcityIdByPY($local);
        $list     = $Goods->getList($items, $cityid, $status, $order, [$dayBegin, $dayEnd], true, $getname);

        if ($lists = $list->toArray()) {
            $page = $list->render();
            foreach ($lists['data'] as $k => $v) {
                $lists['data'][$k]['createdTime'] = date("Y-m-d H:i:s", $v['createdTime']);
                $lists['data'][$k]['paymethod']   = Goods::PAYMETHOD[$v['paymethod']];
                $lists['data'][$k]['is_pay']      = $v['is_pay'] ? '是' : '否';
            }

            // 模板变量赋值
            $this->assign('data', $lists);
            $this->assign('page', $page);
        }

        $this->assign('getname', $getname);
        $this->assign('month_date', $date);
        $this->assign('local', $local);
        $this->assign('title', $this->cities[$local] . '到货');

        return $this->fetch('index');
    }

}
