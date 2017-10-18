<?php

namespace App\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCat extends \Baum\Node
{
    use SoftDeletes;

    protected $appends = [
        'is_nav_name', 'value', 'label', 'title'
    ];


    /* =======================访问器=======================*/
    public function getIsNavNameAttribute() {
        return $this->is_nav ? "导航" : "普通";
    }

    public function getValueAttribute() {
        return $this->id;
    }

    public function getLabelAttribute() {
        return $this->name;
    }

    public function getTitleAttribute() {
        return $this->name;
    }

    /* =======================访问器 end=======================*/


    /* =======================模型关联=======================*/
    //关联用户表
    public function article(){
        return $this->hasMany('App\Models\Article', 'cat_id');
    }

    /* =======================模型关联 end=======================*/
}
