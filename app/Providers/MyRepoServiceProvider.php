<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;
use View;
use Auth;
use App\Repositories\ThirdGuard;
use Storage;
use League\Flysystem\Filesystem;

class MyRepoServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		/**
		 * name => thirdwc
		 * config => [driver => third, provider => wx_users]
		 * @var [type]
		 */
		Auth::extend('third', function ($app, $name, array $config) {		// 注册第三方认证
			$guard = new ThirdGuard($app, $name, $config);				// 初始化 thirdGuard
			$user = $guard->user();										// 初始化用户信息
			return $guard;												// 返回 guard
        });


		/**
		 * 腾讯云对象存储
		 * @var [type]
		 */
		Storage::extend('qcos', function($app, $config) {
			$client = new \App\Repositories\QCos\QCosOper($config);					// qcos 文件存储底层

            return new Filesystem(new \App\Repositories\QCos\QCosAdapter($client));	// laravel 文件存储中间层
        });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'App\Contracts\MyUpload',
			'App\Repositories\UploadManager'
		);


	}

}
