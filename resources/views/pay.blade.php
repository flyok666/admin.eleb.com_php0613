@extends('admin.layout.default')

@section('contents')
    <h1>饿了爸收银台</h1>
    <p>订单编号：{{ $order['sn'] }} 订单金额：{{ $order['total_fee'] }}</p>
    <img src="{{ route('qrcode',['content'=>$code_url]) }}" />
    @stop