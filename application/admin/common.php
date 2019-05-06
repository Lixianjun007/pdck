<?php
/**
 * @author     lxj
 * @date       2018-04-17 11:10:21
 * @filename   common
 */
namespace app\admin;

use think\Controller;
use think\Config;
use think\Response;

class Common extends Controller {

    protected $userInfo = [];
    protected $menu = [];

    public function _initialize() {
//        Request::instance()->session();
//        if($this->_checkLogin()){
//            $this->redirect('admin/index/index');
//        }else{
//            $this->redirect('admin/index/login');
//        }
    }

    public function _checkLogin() {

        $user = session('admin_user');

        if (!$user) {
            $this->redirect('admin/index/login');
        }
        $this->userInfo = $user;
        $this->menu     = Config::get('menu');

        if($this->userInfo['permission'] != 1){
            if($this->userInfo['permission'] == 2){
                unset($this->menu[3]);
            }elseif ($this->userInfo['permission'] == 3){
                unset($this->menu[1]);
                unset($this->menu[3]);
//                unset($this->menu[2][2]);
            }else{
             $this->menu = [];
            }
        }

        $this->assign('useradmin', $this->userInfo);
        $this->assign('leftmenu', $this->menu);
        return true;
    }

    /**
     * @param array $data 返回数据
     * @param string $Code 错误码  默认200 成功
     * @param string $message 成功的信息 默认 success
     * @return \think\Response
     */
    public function sendSuccess($data=[],$Code='200',$message = '提交成功',$headers = []){
        $json = [
            'code'   => intval($Code),
            'error'  =>null,
            'message'=>$message,
            'data'   =>$data
        ];
        return $this->response($json,'json',$Code, $headers);
    }

    /**
     * 输出返回数据
     * @access protected
     * @param mixed     $data 要返回的数据
     * @param String    $type 返回类型 JSON XML
     * @param integer   $code HTTP状态码
     * @return Response
     */
    protected function response($data, $type = 'json', $code = 200 , $headers)
    {
        return Response::create($data, $type , $code, $headers)->code($code);
    }

}
