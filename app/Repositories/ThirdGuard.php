<?php namespace App\Repositories;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class ThirdGuard implements Guard{

	public $user = null;

	public function __construct($app, $name, array $config)
    {
		$this->app = $app;
		$this->name = $name;
		$this->config = $config;
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
        if ($this->loggedOut) {
            return;
        }

        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $id = $this->session->get($this->getName());

        // First we will try to load the user using the identifier in the session if
        // one exists. Otherwise we will check for a "remember me" cookie in this
        // request, and if one exists, attempt to retrieve the user using that.
        $user = null;

        if (! is_null($id)) {
            if ($user = $this->provider->retrieveById($id)) {
                $this->fireAuthenticatedEvent($user);
            }
        }

        // If the user is null, but we decrypt a "recaller" cookie we can attempt to
        // pull the user data on that cookie which serves as a remember cookie on
        // the application. Once we have a user we can return it to the caller.
        $recaller = $this->recaller();

        if (is_null($user) && ! is_null($recaller)) {
            $user = $this->userFromRecaller($recaller);

            if ($user) {
                $this->updateSession($user->getAuthIdentifier());

                $this->fireLoginEvent($user, true);
            }
        }

        return $this->user = $user;
    }


	public function id()
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
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
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        return $this->hasValidCredentials($user, $credentials);
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
		$user = $this->config['provider'];		// model (WxUser)
		$user = $user->findOrFail($id);

		$this->user = $user;
	}


}
