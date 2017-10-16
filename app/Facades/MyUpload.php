<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Foundation\Application
 */
class MyUpload extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'App\Contracts\MyUpload'; }

}
