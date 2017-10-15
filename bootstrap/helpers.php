<?php

if (!function_exists('normalizerUrl')) {
    function normalizerUrl($url) {
        if (preg_match("/^(http:\/\/|https:\/\/)/", $url, $matches)) {
            $url = str_replace($matches[0], '', $url);
            $url = preg_replace('#/+#', '/', $url);
			$url = $matches[0].$url;
        }else {
            $url = preg_replace('#/+#', '/', $url);	// 如果中间出现  // 或者 ///... 替换成 /

            if (!preg_match('/^(\/)/', $url)) {
                $url = "/".$url;
            }
        }

        return $url;
    }
}
