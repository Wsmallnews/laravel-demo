<?php

namespace App\Http\Requests;

use Log;
use Route;
use App\Models\User;

class UserRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'name' => 'unique:agent_users,name',
                    'phone' => 'required|unique:agent_users,phone|regex:/^1[34578][0-9]{9}$/',
                    'password' => 'required|min:6|confirmed'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                $route = Route::currentRouteName();
                $id = $this->route('user');
                if ($route == 'users.editPass' || $route == 'users.resetPass') {
                    return [
                        'password' => 'required|min:6|confirmed'
                    ];
                }

                if($route == 'users.editAgentRank'){
                    return [
                        'agent_rank' => 'required'
                    ];
                }
                // users.update
                return [
                    'name' => 'nullable|unique:agent_users,name,'.$id,
                    'phone' => 'required|unique:agent_users,phone,'.$id.'|regex:/^1[34578][0-9]{9}$/',
                    'email' => 'nullable|email|unique:agent_users,email,'.$id,
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

}
