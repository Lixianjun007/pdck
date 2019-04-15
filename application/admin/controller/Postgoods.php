<?php
/**
 * @author     lxj
 * @date       2018-04-20 05:07:40
 * @filename   Postgoods
 */
namespace app\admin\controller;

use app\admin\Common;
//use app\admin\model\Admin;
use app\admin\model\Goods;
use app\admin\model\City;
use \app\admin\model\Customer;
use \think\Request;

class Postgoods extends Common {

    protected $cities;

    public function _initialize() {
        $this->_checkLogin();
        $this->cities = config('city');
    }

    public function test() {
//        $start    = Request::instance()->param('start');
//        $city     = new Goods();
//        $cityinfo = $city->getTodayNumber(2, 2);
//        var_dump($cityinfo);
//        var_dump(Request::instance()->param('start'));
//        var_dump($_REQUEST);
        $city = new Customer();
        $tmp  = $city->getCustomerId('测试11', '057985513088');
        var_dump($tmp);
    }

    public function index() {
        $start = Request::instance()->param('start');
        if (!array_key_exists($start, $this->cities)) {
            $this->redirect('admin/index/login');
        }
        $items  = 8;             //每页8条
        $status = Goods::STATUS[1];
        $Goods  = new Goods();
        $City   = new City();
        $cityid = $City->getcityIdByPY($start);
        $list   = $Goods->getList($items, $cityid, $status);
        if ($lists  = $list->toArray()) {
            $page = $list->render();
            foreach ($lists['data'] as $k => $v) {
                $lists['data'][$k]['createdTime'] = date("Y-m-d H:i:s", $v['createdTime']);
            }

            // 模板变量赋值
            $this->assign('data', $lists);
            $this->assign('page', $page);
        }

        $this->assign('start', $start);
        $this->assign('title', $this->cities[$start] . '发货');

        return $this->fetch('index');
    }

    /**
     * 管理员添加货物
     */
    public function addgoods() {
        $start = Request::instance()->param('start');
        if (!array_key_exists($start, $this->cities)) {
            $this->redirect('admin/index/login');
        }
        $goods_id = Request::instance()->param('id', false);

        if ($goods_id) {
            $Goods = new Goods();
            $info  = $Goods->getOneInfo($goods_id);
            if ($info) {
                $start = $info['postcityPy'];
                $this->assign('infolist', $info);
            }
        }

        //获取城市列表
        $City     = new City();
        $cityinfo = $City->all()->toArray();

        $this->assign('citylist', $cityinfo);
        $this->assign('start', $start);
        $this->assign('title', $this->cities[$start] . '发货');
        return $this->fetch('addgoods');
    }

    /**
     * 管理员添加货物 ajax
     * @return type
     */
    public function addgoodsAjax() {
        $request  = Request::instance();
        $goods_id = $request->param('id', false);  //判断update/insert

        if (!$request->isAjax()) {
            $this->redirect('admin/index/login');
        }
        $start = $request->param('start');
        if (!array_key_exists($start, $this->cities)) {
            $this->redirect('admin/index/login');
        }

        $City     = new City();
        $Goods    = new Goods();
        $Customer = new Customer();

        $data['updatedTime'] = time();
        if ($goods_id == false) {
            $data['createdTime'] = $data['updatedTime'];
        }
        $data['postcity_id'] = $City->getcityIdByPY($start);   //发货城市id
        $data['getcity_id']  = $request->param('getcityid');
        $data['money']       = $request->param('money');

        $data['number']  = $Goods->getTodayNumber($request->param('number'), $data['postcity_id']);  //获取当日编号
        $data['post_id'] = $Customer->getCustomerId($request->param('postname'), $request->param('postphone'));
        $data['get_id']  = $Customer->getCustomerId($request->param('getname'), $request->param('getphone'));

        $data['paymethod'] = $request->param('paymethod');
        if ($data['paymethod'] == 1) {
            $data['is_pay'] = 1;
        } else {
            $data['is_pay'] = 0;
        }
        $data['zhongzhuan']   = $request->param('zhongzhuan', 0);
        $data['zhida']        = $request->param('zhida', 0);
        $data['address']      = $request->param('address', '');
        $data['operator_uid'] = $this->userInfo['id'];
        $data['status']       = $Goods::STATUS[2];
        if ($goods_id) {
            $result = $Goods->save($data, ['id' => $goods_id]);
        } else {
            $Goods->data($data)->save();
            $result = $Goods->id;
        }
        if ($result) {
            $Customer->addOne($data['post_id'], true);
            $Customer->addOne($data['get_id'], false);
            $result = [
                'data' => $data,
                'code' => 200,
            ];
            return $result;
        }
        return ['data' => '', 'code' => 0];
    }
    
    
    public function edit(){
        
        
        
    }
    

}
