<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends CommonModel
{
    use SoftDeletes;

    protected $appends = [
        'status_name'
    ];



    /* =======================访问器=======================*/
    public function getStatusNameAttribute() {
        return $this->status ? "显示" : "无效";
    }

    /* =======================访问器 end=======================*/


    /* =======================模型关联=======================*/
    //关联用户表
    public function articleCat(){
        return $this->belongsTo('App\Models\ArticleCat', 'cat_id');
    }

    /* =======================模型关联 end=======================*/
}
