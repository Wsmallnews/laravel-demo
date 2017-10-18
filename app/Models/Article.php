<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends CommonModel
{
    use SoftDeletes;

    protected $appends = [
        'status_name'
    ];


    /* =======================修改器=======================*/
    public function setDescAttribute() {
        if (empty($this->desc)) {
            $text = trim(preg_replace('/\s\s+/', ' ', strip_tags($this->content)));      // 过滤html，将多个空格转换成1个，去除两端空格
            $desc = str_limit($text, 200);

            $this->attributes['desc'] = strtolower($desc);
        }
    }

    /* =======================修改器=======================*/


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
