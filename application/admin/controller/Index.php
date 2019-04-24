<?php
namespace app\admin\controller;

use app\admin\Common;
use app\admin\model\Admin;
use \think\Request;
use app\admin\model\Goods;

class Index extends Common {

    public function _initialize() {
        
    }

    public function test() {
//        echo phpinfo();exit;
//        $a = \think\Config::get('menu');
//        $a = url();
//        print_r($a);
//        $admin = new Admin();
//        $a = $admin->test();
//        var_dump($a->toArray());
//        var_dump($a->render());
//        exit;
    }

    public function index() {
        $this->_checkLogin();
        return $this->fetch('index');
    }

    public function login() {
        if (session('admin_user')) {
            $this->redirect('/admin/index');
        }

        return $this->fetch('login');
    }

    /**
     * 登陆验证
     * @author lixianjun
     * Date: 2019/4/24
     * Time: 14:26
     */
    public function logincheck() {
        $a = Request::instance()->isPost();
        if ($a == false) {
            $this->redirect('/admin/index/login');
        }
        $userName = Request::instance()->post('userName', false);
        $passWd   = Request::instance()->post('passWd', false);

        if (!$userName || !$passWd) {
            return $this->error('请填写正确的账号密码');
        }

        $Admin    = new Admin();
        $userInfo = $Admin->getByuserName($userName);
        if (!$userInfo) {
            return $this->error('账号或者用户名不存在');
        }
        if (!$userInfo['status'] != 1) {
            return $this->error('账号已被停用');
        }
        if ($userInfo['passWd'] != md5($passWd)) {
            return $this->error('密码错误');
        }
        session('admin_user', $userInfo);
        $this->redirect('/admin/index');
    }

    public function logout() {
//        \think\Session::destroy();

        session('admin_user', null);
        return $this->success('退出成功！', $this->redirect('/admin/index/login'));
    }

    /**
     * 逻辑删除
     * @return string
     */
    public function del() {
        $this->_checkLogin();
        if (!Request::instance()->isAjax()) {
            $this->redirect('admin/index/login');
        }
        $goods_id    = Request::instance()->param('id', false);
        $operate_uid = $this->userInfo['id'];
        $result      = ['code' => 0, 'data' => 'failed'];
        if ($goods_id && $operate_uid) {
            $Goods = new Goods();
            $tmp   = $Goods->isExists($goods_id);
            if ($tmp && $tmp['status'] != 0) {
                $Goods->update(['id' => $goods_id, 'operator_uid' => $operate_uid, 'status' => 0, 'updatedTime' => time()]);
                $result = ['code' => 200, 'data' => 'success'];
            }
        }
        return $result;
    }

    /**
     * 装车
     * @return string
     */
    public function goodstocar() {
        $this->_checkLogin();
        if (!Request::instance()->isAjax()) {
            $this->redirect('admin/index/login');
        }
        $goods_id    = Request::instance()->param('id/a', false);
        $operate_uid = $this->userInfo['id'];
        $result      = ['code' => 0, 'data' => 'failed'];
        $Goods       = new Goods();
        $res         = $Goods->where('id', 'in', $goods_id)->update(['status' => 3, 'updatedTime' => time(), 'operator_uid' => $operate_uid]);
        if ($res) {
            $result = ['code' => 200, 'data' => 'success'];
        }
        return $result;
    }

    public function show() {
        
    }

}
