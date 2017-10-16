<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCat extends CommonModel
{
    use SoftDeletes ;

    protected $appends = [
        'is_nav_name'
    ];


    /* =======================访问器=======================*/
    public function getIsNavNameAttribute() {
        return $this->is_nav ? "导航" : "普通";
    }

    /* =======================访问器 end=======================*/


    /* =======================模型关联=======================*/
    //关联用户表
    public function article(){
        return $this->hasMany('App\Models\Article', 'cat_id');
    }

    /* =======================模型关联 end=======================*/
}
