<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopCategoryController extends Controller
{
    //
    public function index()
    {
        $shop_categories = ShopCategory::paginate(2);

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
            'img'=>''
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
        return $shop_category->delete();
    }
}
