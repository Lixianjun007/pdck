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

class sendMsgCommand extends Command {

    protected function configure(){
        $this->setName('sendMsgCommand')->setDescription("Acquiescence good evaluate");
    }

    protected function execute(Input $input, Output $output){
        $output->writeln('Date Crontab job start...');
        $this->start();
//        $sendObj = new send();
//        var_dump($sendObj->sendToMsg('李启德||33-4||义乌', 13301760258));
        //"{"SendId":"2019042215512516306967214","InvalidCount":0,"SuccessCount":1,"BlackCount":0,"Code":0,"Message":"OK"}"
        $output->writeln('Date Crontab job end...');
    }

    public function start(){
        $start = 0;
        $datas = $this->getNoPostDatas($start);
        $sendObj = new send();
        while ($datas){
            foreach ($datas as $k => $v){
                $isMatched = preg_match('/(13\d|14[579]|15[^4\D]|17[^49\D]|18\d)+\d{8}/', $v['phone'], $matches);
                if($isMatched){
                    var_dump($v['phone']);
                }
            }
            $start += 2;
            $datas = $this->getNoPostDatas($start);
        }

    }

    public function getNoPostDatas($start){
        $datas = $this->_getTable()->field(['name','phone','city_id','number'])->where(['is_post' => 0])->limit($start,2)->select();
        return $datas;
    }


    public function _getTable(){
        return Db::table("send_msg");
    }



}