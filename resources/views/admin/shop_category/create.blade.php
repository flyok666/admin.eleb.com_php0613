@extends('admin.layout.default')

@section('contents')
    <h1>添加商家分类</h1>
    @include('admin.layout._errors')
    <form method="post" action="{{ route('shop_categories.store') }}" enctype="multipart/form-data">
        <div class="form-group">
            <label>分类名称</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label>分类图片</label>
            <input type="file" name="img">
        </div>
        {{ csrf_field() }}
        <button class="btn btn-primary btn-block">提交</button>
    </form>
@stop