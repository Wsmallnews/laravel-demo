<?php

namespace App\Http\Requests;

use Route;
use App\Models\Article;

class ArticleRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'title' => 'required',
                    'cat_id' => 'required',
                    'content' => 'required',
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                // article.update
                return [
                    'title' => 'required',
                    'cat_id' => 'required',
                    'content' => 'required',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            'title.required' => "文章标题必须填写",
            'cat_id.required' => "分类必须选择",
            'content.required' => "文章内容必须填写",
        ];
    }

}
