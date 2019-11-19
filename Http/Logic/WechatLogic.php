<?php

namespace Qianfangzhifeng\LaravelWechat\Http\Logic;



class WechatLogic
{

    private $wehchat_template;

    /**
     * 分发消息发送的模板
     * @param $postArr
     * @return mixed
     */
    public function send_message_dispatch($postArr){
         //类型判断
         if ($postArr->MsgType == "text" && $postArr->Content == '图文') {
             # 回复图文信息
             $methon = 'wechat_message_template_imgtext';
         } elseif ($postArr->MsgType == "text") {
             # 回复文本信息
             $methon = 'wechat_message_template_text';
         } elseif($postArr->MsgType == "image") {
             # 回复图片信息
             $methon = 'wechat_message_template_image';
         }else{
             return 'false';
         }
         $this -> wehchat_template = config('swechat.wechat_tmp');
         $info   = $this -> {$methon}($postArr);
         return $info;
    }

    /**
     * 回复文字的方法
     * @param $postArr
     * @return string
     */
    private function wechat_message_template_text($postArr){
        //消息内容
        $content      = $postArr->Content;
        //接受者
        $toUserName   = $postArr->ToUserName;
        //发送者
        $fromUserName = $postArr->FromUserName;
        //获取时间戳
        $time         = time();
        //你好，你的消息是： $content
        $content      = "你好，你的消息是： $content";
        //把百分号（%）符号替换成一个作为参数进行传递的变量：
        $info         = sprintf($this -> wehchat_template['text'], $fromUserName, $toUserName, $time, $content);
        return $info;
    }

}
