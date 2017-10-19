<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Auth;
use Crontab\Crontab;

class WxUser extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'expire_at',
    ];

    protected $dates = ['expire_at'];

    public function accessToken(){
        $wxUserS = session('wechat.oauth_user');

        $wxUser = $this->where('wx_openid', $wxUserS->getId())->first();
        if ($wxUser) {
            $wxUser->access_token = md5($wxUserS.time());
            $wxUser->expire_at = Carbon::now()->addHours(24);
            $wxUser->save();

            session(['wx_access_token' => $wxUser->access_token]);
        }
    }


    public function doAdd() {
        $wxUserS = session('wechat.oauth_user');
        $nickname = trim($wxUserS->getNickname());
        $origin_info = $wxUserS->getOriginal();     // 原始数据

        $wxUser->wx_openid = $wxUserS->getId();
        $wxUser->wx_nickname = !empty($nickname) ? $nickname : "";
        $wxUser->wx_sex = isset($origin_info['sex']) ? $origin_info['sex'] : '';
        $wxUser->wx_province = isset($origin_info['province']) ? $origin_info['province'] : '';
        $wxUser->wx_city = isset($origin_info['city']) ? $origin_info['city'] : '';
        $wxUser->wx_country = isset($origin_info['country']) ? $origin_info['country'] : '';
        $wxUser->wx_headimgurl = $wxUserS->getAvatar();

        $wxUser->save();

        if (empty($wxUser->wx_nickname))  {
            $wxUser->wx_nickname = "cysh_".$wxUser->id;      // 如果nickname 为空，更新
            $wxUser->save();
        }
    }


    public function updateInfo(){
        $wxUserS = session('wechat.oauth_user');
        $nickname = trim($wxUserS->getNickname());  // 微信昵称
        $origin_info = $wxUserS->getOriginal();     // 原始数据

        $wxUser = $this->where('wx_openid', $wxUserS->getId())->first();

        if (!empty($wxUser)) {
            // 更新
            $wxUser->wx_nickname = !empty($nickname) ? $nickname : (!empty($wxUser->wx_nickname) ? $wxUser->wx_nickname : "wfs_".$wxUser->id);
            $wxUser->wx_sex = isset($origin_info['sex']) ? $origin_info['sex'] : '';
            $wxUser->wx_email = isset($origin_info['email']) ? $origin_info['email'] : '';
            $wxUser->wx_province = isset($origin_info['province']) ? $origin_info['province'] : '';
            $wxUser->wx_city = isset($origin_info['city']) ? $origin_info['city'] : '';
            $wxUser->wx_country = isset($origin_info['country']) ? $origin_info['country'] : '';
            $wxUser->wx_headimgurl = $wxUserS->getAvatar();

            $wxUser->save();
        }else if (!empty($wxUserS->getId())) {
            $wxUser = new UserWx();

            $wxUser->wx_openid = $wxUserS->getId();
            $wxUser->wx_nickname = !empty($nickname) ? $nickname : "";
            $wxUser->wx_sex = isset($origin_info['sex']) ? $origin_info['sex'] : '';
            $wxUser->wx_email = isset($origin_info['email']) ? $origin_info['email'] : '';
            $wxUser->wx_province = isset($origin_info['province']) ? $origin_info['province'] : '';
            $wxUser->wx_city = isset($origin_info['city']) ? $origin_info['city'] : '';
            $wxUser->wx_country = isset($origin_info['country']) ? $origin_info['country'] : '';
            $wxUser->wx_headimgurl = $wxUserS->getAvatar();

            $wxUser->save();

            if (empty($wxUser->wx_nickname))  {
                $wxUser->wx_nickname = "wfs_".$wxUser->id;      // 如果nickname 为空，更新

                $wxUser->save();
            }
        } else {
            return;
        }

        $user = User::find($wxUser->user_id);

        if (!empty($user)) {    // 用户存在
            // 更新用户未填写信息
            $user->name = empty($user->name) ? $wxUser->wx_nickname : $user->name;
            $user->avatar = empty($user->avatar) ? $wxUser->wx_headimgurl : $user->avatar;
            $user->email = empty($user->email) ? $wxUser->wx_email : $user->email;

            $user->save();
        }else {
            $user = new User();

            $user->wx_openid = $wxUser->wx_openid;
            $user->name = empty($user->name) ? $wxUser->wx_nickname : $user->name;
            $user->avatar = empty($user->avatar) ? $wxUser->wx_headimgurl : $user->avatar;
            $user->email = empty($user->email) ? $wxUser->wx_email : $user->email;

            $user->save();

            $wxUser->user_id = $user->id;   // 更新 微信用户 user_id
            $wxUser->save();
        }
        // login
        Auth::loginUsingId($user->id);
        return;
    }
}
