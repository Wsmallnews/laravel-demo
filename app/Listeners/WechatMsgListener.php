<?php

namespace App\Listeners;

use App\Events\WechatMsgEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use EasyWeChat;
use Log;

class WechatMsgListener implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param  WechatMsgEvent  $event
     * @return void
     */
    public function handle(WechatMsgEvent $event)
    {
        $tempData = $event->tempData;
        $tempTpl = config('wechat.template_msg.'.config('app.env').".".$tempData['temp_name']);
        $tempTpl['touser'] = $tempData['touser'];
        $tempTpl['url'] = !empty($tempData['url']) ? $tempData['url'] : "";

        if (!empty($tempData['data'])) {
            $tempTpl['data'] = array_merge($tempTpl['data'], $tempData['data']);
        }

        $result = EasyWeChat::notice()
                    ->uses($tempTpl['template_id'])
                    ->withUrl($tempTpl['url'])
                    ->andData($tempTpl['data'])
                    ->andReceiver($tempTpl['touser'])->send();

        if ($result['errcode']) {
            Log::error($result['errmsg']);
        }
    }
}
