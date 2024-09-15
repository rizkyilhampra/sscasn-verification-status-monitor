<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function parseCurlCommand($curlCommand)
    {
        $result = [
            'x_xsrf_token' => '',
            'cookies' => [],
        ];

        preg_match("/-H 'X-XSRF-TOKEN: ([^']+)'/", $curlCommand, $matches);
        if (isset($matches[1])) {
            $result['x_xsrf_token'] = $matches[1];
        }

        preg_match("/-H 'Cookie: ([^']+)'/", $curlCommand, $matches);
        if (isset($matches[1])) {
            $cookiePairs = explode('; ', $matches[1]);
            foreach ($cookiePairs as $pair) {
                [$name, $value] = explode('=', $pair, 2);
                $result['cookies'][$name] = $value;
            }
        }

        return $result;
    }
}
