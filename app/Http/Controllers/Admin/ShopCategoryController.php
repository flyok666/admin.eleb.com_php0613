<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ShopCategoryController extends Controller
{
    //
    public function index()
    {
        //使用阿里云对象存储

        //Storage::disk('oss');//使用阿里云oss存储文件
        //Storage::put('path/to/file/file.jpg', $contents); //first parameter is the target file path, second paramter is file content
        //Storage::putFile('path/to/file/file.jpg', 'local/path/to/local_file.jpg'); // upload file from local path
        $shop_categories = ShopCategory::paginate(5);
        //Storage::put('pic/1.jpg', file_get_contents(public_path('images/1.jpg')));//上传
        //return '上传成功';
        //dd(Storage::url('pic/1.jpg'));
        return view('admin.shop_category.index',compact('shop_categories'));

    }

    public function create()
    {
        return view('admin.shop_category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
        ]);

        $shop_category = ShopCategory::create([
            'name'=>$request->name,
            'status'=>1,
            'img'=>$request->img
        ]);

        return redirect()->route('shop_categories.index')->with('success',"商品分类【{$shop_category->name}】添加成功");
    }

    public function show()
    {
        
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy(ShopCategory $shop_category){
        $shop_category->delete();
        return 'success';
    }
    
    //接收webuploader文件上传
    public function upload(Request $request)
    {
        $path = $request->file('file')->store('public/img');
        return ['path'=>Storage::url($path)];
    }
}
