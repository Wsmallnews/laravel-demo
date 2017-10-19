<?php namespace App\Repositories;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Carbon\Carbon;

class ThirdGuard implements Guard{

	public $user = null;

	public function __construct($app, $name, array $config, $callback)
    {
		$this->app = $app;
		$this->name = $name;
		$this->config = $config;
		$this->$callback = $callback;
    }


	/**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ! is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return ! $this->check();
    }

	/**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        // 通过 access_token 获取用户信息
		$user = $this->accessAutoLogin();

        return $this->user = $user;
    }


	public function id()
    {
        if ($this->user()) {
            return $this->user()->id;
        }
    }

	/**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $this->accessAutoLogin();
		return !is_null($this->user);	// 如果当前用户存在，返回 true
    }


	/**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return $this
     */
    public function setUser(AuthenticatableContract $user)
    {
        $this->user = $user;

        return $this;
    }


	// 通过 id 登录
	public function loginUsingId($id) {
		$user = $this->getModel()->findOrFail($id);

		$this->user = $user;
	}


	private function accessAutoLogin(){
		$access_token = request()->input('wx_access_token');

		$user = $this->getModel()->where('access_token', $access_token)->find($id);

		$this->user = null;
		if ($user) {
			if (Carbon::now() < $user->expire_at) {
				$this->user = $user;
			}
		}
	}


	private function getModel() {
		return $this->config['provider'];		// model (WxUser)
	}
}
