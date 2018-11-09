@extends('admin.layout.default')

@section('contents')
    <table class="table table-bordered">
        <tr>
            <th>订单编号</th>
            <th>订单商品</th>
            <th>价格</th>
            <th>创建时间</th>
            <th></th>
        </tr>
        <tr>
            <td>201811091234</td>
            <td>iPhone X</td>
            <td>8888</td>
            <td>2018-11-09 10:11:12</td>
            <td><a class="btn btn-info" href="{{ route('wechat.pay',['id'=>1]) }}">支付</a> </td>
        </tr>
        <tr>
            <td>201811091234</td>
            <td>小米7</td>
            <td>2888</td>
            <td>2018-11-09 12:11:12</td>
            <td><a class="btn btn-info" href="{{ route('wechat.pay',['id'=>2]) }}">支付</a> </td>
        </tr>
    </table>
    @stop