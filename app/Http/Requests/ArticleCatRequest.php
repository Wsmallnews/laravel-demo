<?php

namespace App\Http\Requests;

use Route;
use App\Models\ArticleCat;

class ArticleCatRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'name' => 'required'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required'
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
            'name.required' => "分类名称必须填写",
        ];
    }
}
