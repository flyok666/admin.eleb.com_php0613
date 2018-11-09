<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use EasyWeChat\Factory;
use EasyWeChatComposer\EasyWeChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;

class WechatController extends Controller
{
    //
    public function pay(Request $request)
    {
        //订单id
        $id = $request->id;
        //$order = Order::find($id);
        $order=[
            'sn'=>'201811091113311234',
           'out_trade_no'=>'12rtrt331234fdf',
            'total_fee'=>111.01
        ];


        $app = app('wechat.payment');
        //$payment = EasyWeChat::payment(); // 微信支付
        //dd($payment);

        //$app = EasyWeChat::payment(); // 微信支付
        //1 生成订单（微信支付订单）
        //2 调用统一下单api
        $result = $app->order->unify([
            'body' => '饿了爸订单',
            'out_trade_no' => $order['out_trade_no'],
            'total_fee' => $order['total_fee']*100,//订单价格（注意：单位是分）
            //'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            //'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'NATIVE', // 请对应换成你的支付方式对应的值类型  NATIVE扫码支付
            //'openid' => 'oUpF8uMuAJO_M2pxb1Q9zNjWeS6o',
        ]);

        //3 获取响应里面的code_url
        if($result['return_code']=='SUCCESS' || $result['return_msg']=='OK'){
            //请求成功
            $code_url = $result['code_url'];

            return view('pay',compact('order','code_url'));
        }
        //dump($result);//code_url

        
    }

    //二维码生成器
    public function Qrcode(Request $request)
    {
        $qrCode = new QrCode($request->input('content'));

        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }
    
    //支付结果通过
    public function notify()
    {
        $app = app('wechat.payment');
        $response = $app->handlePaidNotify(function($message, $fail) use ($app){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
//            $order = 查询订单($message['out_trade_no']);
            $order = Order::where('out_trade_no',$message['out_trade_no'])->first();

            if (!$order || $order->status != 0) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            $result = $app->order->queryByOutTradeNumber($message['out_trade_no']);
            //根据$result的支付结果处理订单
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    //$order->paid_at = time(); // 更新支付时间为当前时间
                    //$order->status = 'paid';
                    //发货操作
                    $order->update(['status'=>1]);

                    // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    //$order->status = 'paid_fail';
                    //取消订单 或者 不管
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            //$order->save(); // 保存订单

            return true; // 返回处理完成
        });

        $response->send(); // return $response;
    }

    //主动查询订单支付结果
    public function query()
    {
        $app = app('wechat.payment');
        $result = $app->order->queryByOutTradeNumber('12rtrt1234fdf');
        dd($result);
    }
}
