<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use EasyWeChat;
use App\Models\WxUser;
use Log;

class WeAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 测试本地环境直接自动 登录
        if (config('app.env') == 'local' && config('wechat.enable_mock')) {
            $info = config('wechat.mock_user');
            Auth::guard($guard)->loginUsingId($info['id']);

            return $next($request);
        }

        $isNewSession = false;
        $onlyRedirectInWeChatBrowser = config('wechat.oauth.only_wechat_browser', true);

        if ($onlyRedirectInWeChatBrowser && !$this->isWeChatBrowser($request)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('请在微信浏览器打开', 401);
            }

            abort(404, "请在微信浏览器打开");
        }

        $scopes = ['snsapi_userinfo'];

        if (!Auth::guard($guard)->check()) {
            if ($request->has('code')) {
                session(['wechat.oauth_user' => EasyWeChat::oauth()->user()]);
                $isNewSession = true;

                // 更新用户信息
                $wxUser = new WxUser();
                $wxUser->doAdd();

                // 登录
                $userWx->accessToken();
                return redirect($this->getTargetUrl($request));
            }

            session()->forget('wechat.oauth_user');
            return EasyWeChat::oauth()->scopes($scopes)->redirect($request->fullUrl());
        }

        return $next($request);
    }


    /**
     * Detect current user agent type.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isWeChatBrowser($request)
    {
        return strpos($request->header('user_agent'), 'MicroMessenger') !== false;
    }


    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['code', 'state']);

        return $request->url().(empty($queries) ? '' : '?'.http_build_query($queries));
    }
}
