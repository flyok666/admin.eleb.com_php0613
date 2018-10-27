<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    //商家列表
    public function list()
    {
        //获取所有商家信息
        /*$shops = Shop::all();

        $datas = [];
        foreach($shops as $shop){
            $data = [
                "id"=> $shop->id,
                "shop_name"=>$shop->name,
                //...
                "notice"=> $shop->notice,
                "discount"=> $shop->discount
            ];

            $datas[] = $data;
        }
        return $datas;*/
        //return response()->header();
        return '[
      {
        "id": "s10001",
        "shop_name": "上沙麦当劳",
        "shop_img": "/images/shop-logo.png",
        "shop_rating": 4.7,
        "brand": true,
        "on_time": true,
        "fengniao": true,
        "bao": true,
        "piao": true,
        "zhun": true,
        "start_send": 20,
        "send_cost": 5,
        "distance": 637,
        "estimate_time": 30,
        "notice": "新店开张，优惠大酬宾！",
        "discount": "新用户有巨额优惠！"
      }
      
    ]';
    }
    
}
