<?php

namespace App\Http\Controllers\User;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Validator;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {
        //验证数据
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required'=>'用户名不能为空',
            'password.required'=>'密码不能为空',
        ]);
        //验证失败
        if ($validator->fails()) {
            return [
                'error_code'=>-2,
                //'message'=>'用户名密码不能为空'
                'message'=>$validator->errors()
                //$validator->errors()获取字段验证错误信息
            ];
        }

        //登录验证
        if(Auth::attempt(['name'=>$request->username,'password'=>$request->password])){
            return [
                "error_code"=> 0,
                "message" => "登录成功",
            ];
        }
        return [
            "error_code"=> -1,
            "message" => [
                'username'=>[
                    '用户名或密码错误,请重新输入'
                ]
            ],
        ];
        //返回结果

        //return 'login';
    }

    //接口 登录
    public function userLogin(Request $request)
    {
        //数据验证

        $credentials=[
            'username'=>$request->username,
            'password'=>$request->password,
        ];
        //登录验证
        if(Auth::once($credentials)) {
            //用户id
            $user = User::where('username',$request->username)->first();
            $token = md5($user->id.time());
            Redis::set($token,$user->id,7*24*3600);// sdhfhsfkjh324234234 => 1  ,7天过期
            return [
                'error_code'=>0,
                'msg'=>'登录成功',
                'data'=>[
                    'user_id'=>$user->id,
                    'token'=>$token
                ]
            ];
        }else{
            return [
                'error_code'=>-1,
                'msg'=>'登录失败',
                'data'=>[

                ]
            ];
        }
    }


    //接口  订单列表接口（需要登录）
    public function orderList(Request $request)
    {
        //请求该接口必须要user_id和token
        //数据验证
        $user_id = $request->user_id;
        $token = $request->token;

        //验证token有效性
        $uid = Redis::get($token);
        if($uid == $user_id){
            //验证通过，相当于该用户已登录
            $orders = Order::where('user_id',$user_id)->get();

            //token延期
            Redis::expire($token,7*24*3600);
            return [
                'error_code'=>0,
                'msg'=>'',
                'data'=>$orders
            ];
        }else{
            return [
                'error_code'=>-1,
                'msg'=>'token已失效，请重新获取',
                'data'=>[]
            ];
        }

        //$user_id = Auth::user()->id;


    }

    //http://www.xxx.com/pay?sn=1231223123&price=8888&content=iphonex&time=123123123123&sign=HJGDYU546GFGHFK675JH
    //密钥
    /*$key = '随机字符串，比较长，比较复杂HJghdfhg235456423hjgs@#%￥dhg';
        //支付接口  订单信息  订单编号 订单金额 (iphoneX 8888) 0.01
    $data = ['sn'=>'201811081234', 'price'=>8888,  'content'=>'iPhone X 256G','time'=>time()];
        //对key做升序排序
    ksort($data);//['content'=>,'p','s','t']
    $str = '';
    foreach ($data as $k=>$v){
    $str .= $k.$v;
    }
    //contentiPhone X 256Gprice8888sn201811081234time1311231231
    $sign = strtoupper(md5($key.$str));// HJGDYU546GFGHFK675JH*/

    //数字签名  保证数据不被篡改
    public function pay(Request $request)
    {
        $key = '随机字符串，比较长，比较复杂HJghdfhg235456423hjgs@#%￥dhg';
        //验证参数有消性

        //时间戳 时效性 （重放攻击）
        //只允许请求时间±10秒的请求      [ time()-5   time()+5]
        if( $request->time >= time()-5 && $request->time <= time()+5){
            //时间戳有效
        }else{
            //时间戳
        }

        //验证签名有效期
        $data = $request->input();
        unset($data['sign']);
        ksort($data);
        $str = '';
        foreach ($data as $k=>$v){
            $str .= $k.$v;
        }

        $sign = strtoupper(md5($key.$str));
        if($sign == $request->sign){
            //签名有效
        }else{
            //签名无效，
        }
    }


    public function shopList()
    {

        //使用redis缓存
        $data = Redis::get('shops');
        if(!$data){
            $shops = Shop::all();

            //数据调整

            Redis::set('shops',serialize($shops));
            Redis::expire('shops',3600);//1小时过期
        }else{
            $shops = unserialize($data);
        }


        return $shops;

    }

    public function shop(Request $request)
    {
        //使用redis缓存
        $data = Redis::get('shop_'.$request->id);
        if(!$data) {
            $shop = Shop::find($request->id);

            //数据处理

            Redis::set('shop_'.$request->id,serialize($shop));
            Redis::expire('shop_'.$request->id,3600);//1小时过期

        }else{
            $shop = unserialize($data);
        }

        return json_encode($shop);
    }

    //活动列表页
    public function eventList()
    {
        $events = Event::paginate(10);
    }

    //活动首页 （最新活动，有效期内的活动，正在开展的活动）
    public function eventIndex()
    {
        $events = Event::where('status',1)->get();
        //页面静态化
        //1.获取页面输出（ob，模板替换）
        $content = view('list',compact('events'));
        //2.输出内容保存到html页面中   public/html/events.html
        file_put_contents(public_path().'/html/events.html',$content);

        return $content;
    }

    //活动详情页
    public function event(Request $request)
    {
        $event = Event::find($request->id);

        $content =  view('show',compact('event'));

        //前提：如果目录不存在，则需要先创建
        //      public/html/event/201811/id.html
        file_put_contents(public_path().'/html/event/'.date('Ym').'/'.$request->id.'.html');

    }
}
