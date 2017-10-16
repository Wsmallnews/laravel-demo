<?php

namespace App\Listeners;

use App\Events\AdminLogEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminLog;
use Request;
use Auth;

class AdminLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminLogEvent  $event
     * @return void
     */
    public function handle(AdminLogEvent $event)
    {
        //记录日志
		$data = $event->adminLogData;

		$adminLog = new AdminLog();
		$adminLog->user_id = isset($data['user_id']) ? $data['user_id'] : Auth::guard('api')->id();
		$adminLog->log_info = $data['log_info'];
		$adminLog->ip_address = Request::ip();
		$adminLog->save();
		return true;
    }
}
