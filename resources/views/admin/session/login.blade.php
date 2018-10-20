@extends('admin.layout.default')

@section('contents')
    <div class="row">
        <div class="col-lg-3 col-lg-offset-4">

            <ul id="myTab" class="nav nav-tabs">
                <li class="active">
                    <a href="#name" data-toggle="tab">账号密码登录</a>
                </li>
                <li><a href="#phone" data-toggle="tab">手机验证码登录</a></li>
            </ul>



            <div id="myTabContent" class="tab-content"><br>
                <div class="tab-pane fade in active" id="name">
                    <form method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                <input type="text" class="form-control" name="username" placeholder="用户名">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                <input type="password" class="form-control" name="password" placeholder="密码">
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <button class="btn btn-primary btn-block">登录</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="phone">
                    <form method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></div>
                                <input type="text" class="form-control" name="phone" placeholder="手机号码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control"  name="sms" placeholder="手机验证码">
                                <span class="input-group-btn"><button type="button" class="btn btn-default" >获取验证码</button></span>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <button class="btn btn-primary btn-block">登录</button>
                    </form>
                </div>
            </div>
            <hr>
            <p class="text-nowrap">
                <a href="{{ route('register') }}">注册账号</a>
                <a class="pull-right">忘记密码</a>
            </p>
        </div>
    </div>
@stop