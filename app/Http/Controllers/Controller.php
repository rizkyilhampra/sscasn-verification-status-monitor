<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

abstract class Controller
{
    protected function parseCurlCommand($curlCommand)
    {
        $result = [
            'x_xsrf_token' => '',
            'cookies' => [],
        ];

        preg_match("/-H 'X-XSRF-TOKEN: ([^']+)'/", $curlCommand, $matches);
        if (! isset($matches[1])) {
            throw ValidationException::withMessages([
                'curl_command' => 'Curl command tidak mengandung XSRF Token yang valid.',
            ]);
        }
        $result['x_xsrf_token'] = $matches[1];

        preg_match("/-H 'Cookie: ([^']+)'/", $curlCommand, $matches);
        if (! isset($matches[1])) {
            throw ValidationException::withMessages([
                'curl_command' => 'Curl command tidak mengandung cookies yang valid.',
            ]);
        }
        $cookiePairs = explode('; ', $matches[1]);
        foreach ($cookiePairs as $pair) {
            [$name, $value] = explode('=', $pair, 2);
            $result['cookies'][$name] = $value;
        }

        return $result;
    }
}
