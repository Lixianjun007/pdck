<?php

/**
 * Created by PhpStorm.
 * User: lixianjun
 * Date: 2019/4/22
 * Time: 14:46
 */

namespace Msg;

class send
{

    protected $url        = "http://api.feige.ee/SmsService/Template";
    protected $account    = '17621753088';
    protected $pwd        = '363bc24cb077337af12c49bb4';
    protected $templateId = 64298;

    public function sendToMsg($content, $mobile)
    {
        $data['Account']    = $this->account;
        $data['Pwd']        = $this->pwd;
        $data['Content']    = $content;
        $data['Mobile']     = $mobile;
        $sign               = config('sign');
        $data['TemplateId'] = 64298;
        $data['SignId']     = $sign['yw_pd'];

        return $this->post($this->url, $data);
    }

    private function post($url, $data, $proxy = null, $timeout = 20)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3100.0 Safari/537.36'); //在HTTP请求中包含一个"User-Agent: "头的字符串。
        curl_setopt($curl, CURLOPT_HEADER, 0); //启用时会将头文件的信息作为数据流输出。
        curl_setopt($curl, CURLOPT_POST, true); //发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//Post提交的数据包
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //文件流形式
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); //设置cURL允许执行的最长秒数。
        $content = curl_exec($curl);
        curl_close($curl);
        unset($curl);
        return $content;
    }

}