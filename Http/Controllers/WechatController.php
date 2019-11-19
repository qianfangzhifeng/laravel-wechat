<?php
namespace Qianfangzhifeng\LaravelWechat\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Qianfangzhifeng\LaravelWechat\Http\Logic\WechatLogic;


class WechatController extends Controller
{
    public function index(WechatLogic $wechatLogic){
        // 回复信息
        // 接收微信发送的参数
        $postObj     = file_get_contents('php://input');
        $postArr     = simplexml_load_string($postObj,"SimpleXMLElement",LIBXML_NOCDATA);
        $info        = $wechatLogic -> send_message_dispatch($postArr);
        return $info;

    }

}
