<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ShopCategoryController extends Controller
{
    //
    public function index(Request $request)
    {

        //dd($request->except('page'));
        //$shop_categories = ShopCategory::paginate(2);
        //where([ [条件1],[条件2] ...    ]);
        $wheres = [];
        if($request->name){
            $wheres[] = ['name','like',"%{$request->name}%"];
        }
        /*if($request->min_price){
            $wheres[] = ['price','>=',$request->min_price];
        }
        if($request->max_price){
            $wheres[] = ['price','<=',$request->max_price];
        }*/
        $shop_categories = ShopCategory::where($wheres)->paginate(2);

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
