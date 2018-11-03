<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;

class TongJiController extends Controller
{
    //最近一周每日订单量统计
    public function order_week()
    {
        $shop_id = 1;//Auth::user()->shop_id;
        $time_start = date('Y-m-d 00:00:00',strtotime('-6 day'));
        $time_end = date('Y-m-d 23:59:59');
        $sql = "SELECT DATE(created_at) AS date,COUNT(*) AS total FROM orders WHERE created_at >= '{$time_start}' AND created_at <= '{$time_end}' AND shop_id = {$shop_id} GROUP BY DATE(created_at)";

        $rows = DB::select($sql);
        //$rows = [
        // ['date'=>'','total'=>''],[]
        //];
        //构造7天统计格式
        $result = [];
        for ($i=0;$i<7;$i++){
            //处理日期过长
            $result[date('Y-m-d',strtotime("-{$i} day"))] = 0;
        }
        //dd($result);
        foreach ($rows as $row){
            //$row->date 2018-11-02  ===> 11-02
            //$result[substr($row->date,5,5)] = $row->total;
            $result[$row->date] = $row->total;
        }


        //dd($result);
        return view('shop.order_week',compact('result'));
    }
//商户端最近一周菜品销量统计
    public function menu_week()
    {
        $shop_id = 1;//Auth::user()->shop_id;
        $time_start = date('Y-m-d 00:00:00',strtotime('-6 day'));
        $time_end = date('Y-m-d 23:59:59');
        $sql = "SELECT
	DATE(orders.created_at) AS date,order_details.goods_id,
	SUM(order_details.amount) AS total
FROM
	order_details
JOIN orders ON order_details.order_id = orders.id
WHERE
	 orders.created_at >= '{$time_start}' and orders.created_at <= '{$time_end}'
AND shop_id = {$shop_id}
GROUP BY
	DATE(orders.created_at),order_details.goods_id";

        $rows = DB::select($sql);
        //dd($rows);
        //$rows = [
        // ['date'=>'','total'=>''],[]
        //];
        //构造7天统计格式
        $result = [];
        //获取当前商家的菜品列表
        $menus = Menu::where('shop_id',$shop_id)->select(['id','goods_name'])->get();
        $keyed = $menus->mapWithKeys(function ($item) {
        return [$item['id'] => $item['goods_name']];
    });
        $keyed2 = $menus->mapWithKeys(function ($item) {
            return [$item['id'] => 0];
        });
        $menus = $keyed->all();
        //dd($menus);
        $week=[];
        for ($i=0;$i<7;$i++){
            $week[] = date('Y-m-d',strtotime("-{$i} day"));
        }
        foreach ($menus as $id=>$name){
            foreach ($week as $day){
                $result[$id][$day] = 0;
            }
        }
        /**/
        //dd($result);
        foreach ($rows as $row){
            $result[$row->goods_id][$row->date]=$row->total;
        }


        //dd($result);
        $series = [];
        foreach ($result as $id=>$data){
            $serie = [
                'name'=> $menus[$id],
                'type'=>'line',
                'stack'=> '销量',
                'data'=>array_values($data)
            ];
            $series[] = $serie;
        }
       /* [
                {
                    name:'回锅肉',
                    type:'line',
                    stack: '总量',
                    data:[120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name:'联盟广告',
                    type:'line',
                    stack: '总量',
                    data:[220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name:'视频广告',
                    type:'line',
                    stack: '总量',
                    data:[150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name:'直接访问',
                    type:'line',
                    stack: '总量',
                    data:[320, 332, 301, 334, 390, 330, 320]
                },
                {
                    name:'搜索引擎',
                    type:'line',
                    stack: '总量',
                    data:[820, 932, 901, 934, 1290, 1330, 1320]
                }
            ]*/

        return view('shop.menu_week',compact('result','menus','week','series'));

    }
}
