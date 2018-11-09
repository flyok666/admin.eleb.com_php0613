<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('about',function(){
    return 'about';
});

Route::domain('admin.eleb.com')->group(function () {
    Route::namespace('Admin')->group(function (){
        Route::get('shop_categories/category/{id}','ShopCategoryController@index');
        Route::resource('shop_categories','ShopCategoryController');
        Route::resource('shops','ShopController');

        Route::get('login','SessionController@login')->name('login');
        Route::get('logout','SessionController@logout')->name('logout');
        Route::get('register','SessionController@register')->name('register');


        //文件上传
        Route::post('upload','ShopCategoryController@upload')->name('upload');
        //RBAC
        Route::get('rbac','RbacController@index')->name('rbac');

        Route::get('rbac/test','RbacController@test')->name('rbac/test');

        //订单列表
        Route::get('wechat/orderList',function(){
            return view('orderList');
        });

        //微信支付
        Route::get('wechat/pay/{id}','WechatController@pay')->name('wechat.pay');
        //支付成功通知地址
        Route::any('wechat/notify','WechatController@notify')->name('wechat.notify');
        //二维码
        Route::get('qrcode','WechatController@qrcode')->name('qrcode');
        //支付结果查询
        Route::get('query','WechatController@query');


        //测试中文分词搜索
        Route::get('search','SearchController@index');

    });

});


//商户端
Route::domain('shop.eleb.com')->group(function () {
    //最近一周订单量统计
    Route::get('order/week','Shop\TongJiController@order_week');
    //商户端最近一周菜品销量统计
    Route::get('menu/week','Shop\TongJiController@menu_week');








});


Route::domain('www.eleb.com')->group(function () {

    //用户端
    Route::post('user/login','User\UserController@login');

    //商家列表
    Route::get('shop/list','User\ShopController@list');


});

//发送短信接口
Route::get('sms',function(){
    $params = array ();

    // *** 需用户填写部分 ***
    // fixme 必填：是否启用https
    $security = false;

    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    $accessKeyId = "LTAIQAIw4ArDfPMB";
    $accessKeySecret = "lx5V395m5QJZ6Jk9C3TUwmzmiKKphD";

    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] = "17612858269";

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = "Sakura个人记录";

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = "SMS_149102596";

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    $params['TemplateParam'] = Array (
        "code" => rand(1000,9999),
        //"product" => "阿里通信"
    );

    // fixme 可选: 设置发送短信流水号
    $params['OutId'] = "12345";

    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
    $params['SmsUpExtendCode'] = "1234567";


    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new \App\Models\SignatureHelper();

    // 此处可能会抛出异常，注意catch
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        )),
        $security
    );

    dd($content);
});