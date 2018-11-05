<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    //
    //获取导航菜单
    public static function getNavs()
    {
        $html = '';
        //生成导航菜单组

        //1 获取所有一级菜单
        //$navs = Nav::where('pid',0)->get();
        $navs = [
            [
                'id'=>'1',
                'name'=>'用户管理',
                'url'=>''
            ],
            [
                'id'=>'2',
                'name'=>'文章管理',
                'url'=>''
            ]
        ];
        //遍历一级菜单，生成html
        foreach ($navs as $nav){
            $html .=  '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$nav['name'].' <span class="caret"></span></a>
                    <ul class="dropdown-menu">';
            //获取该一级菜单的子菜单
            //$children = Nav::where('pid',$nav['id'])->get();
            $children = [
                [
                    'id'=>'3',
                    'name'=>'添加用户',
                    'url'=>'user/add'
                ],
                [
                    'id'=>'4',
                    'name'=>'用户列表',
                    'url'=>'user'
                ]
            ];
            foreach ($children as $child){
                $html .= '<li><a href="'.$child['url'].'">'.$child['name'].'</a></li>';
            }
//            <li><a href="#">二级菜单1</a></li>
//                       <li><a href="#">二级菜单2</a></li>
             $html .= '</ul></li>';
        }

        return $html;
    }
}
