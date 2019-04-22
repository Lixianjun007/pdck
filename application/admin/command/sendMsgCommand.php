<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/22
 * Time: 14:20
 */

namespace app\admin\command;

use Msg\send;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
ini_set('max_execution_time','20');
class sendMsgCommand extends Command
{

    protected function configure()
    {
        $this->setName('sendMsgCommand')->setDescription("Acquiescence good evaluate");
    }

    public $obj;

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('send msg job start...');
        $this->start();
        $output->writeln('send msg job end...');
    }

    public function start()
    {
        Db::startTrans();
        $datas = $this->getNoPostDatas();
        while ($datas) {
            foreach ($datas as $k => $v) {
                $isMatched = preg_match('/(13\d|14[579]|15[^4\D]|17[^49\D]|18\d)+\d{8}/', $v['phone'], $matches);
                if ($isMatched) {
                    if ($this->doSend($v['name'], $v['phone'], $v['number'], $v['city_id'])) {
                        $this->_getTable()->where(['id' => $v['id']])->update(['is_post' => 1, 'post_date' => date('Y-m-d H:i:s')]);
                    }
                } else {
                    $this->_getTable()->where(['id' => $v['id']])->delete();
                }
            }
            $datas = $this->getNoPostDatas();
        }
        Db::commit();
        return true;
    }

    public function getNoPostDatas()
    {
        $datas = $this->_getTable()
            ->field(['id', 'name', 'phone', 'city_id', 'number'])
            ->where(['is_post' => 0])
            ->limit(2)
            ->select();
        return $datas;
    }

//     */10 * * * * php /www/wwwroot/www.pindi3088.cn/think sendMsgCommand >> /www/wwwroot/www.pindi3088.cn/runtime/command/sendMsg-$(date +\%Y-\%m-\%d).log
    /**
     * 发送短信函数
     * @param $name
     * @param $phone
     * @param $number
     * @param $city_id
     */
    public function doSend($name, $phone, $number, $city_id)
    {
        if ($city_id == 1) {
            $city = '义乌';
        } else {
            $city = '上海';
        }
        $contend = "$name||$number||$city";
        $result = $this->_sendObj()->sendToMsg($contend, $phone);
        var_dump($result);
        $results = json_decode($result, true);
        if ($results['Message'] == 'OK') {
            sleep(30);
            echo "send to " . $contend . "\n";
            Db::table("msg_log")->insert(['phone' => $phone, 'msg' => $contend, 'created_at' => date('Y-m-d H:i:s')]);
            return true;
        } else {
            sleep(30);
            return false;
        }
    }

    public function _sendObj()
    {
        return $this->obj = new send();
    }

    public function _getTable()
    {
        return Db::table("send_msg");
    }


}