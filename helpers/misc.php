<?php

use Illuminate\Support\Arr;

if (! function_exists('auth0_config')) {
    /**
     * @param string $key
     * @return mixed
     */
    function auth0_config(string $key)
    {
        return config("auth0.{$key}");
    }
}

if (! function_exists('auth0_config_client')) {
    /**
     * @param string $key
     * @return mixed
     */
    function auth0_config_client(string $key)
    {
        $type = auth0_config('current_client');

        return auth0_config("client.{$type}.{$key}");
    }
}

if (! function_exists('conf_auth0')) {
    /**
     * @param string $key
     * @return mixed
     */
    function conf_auth0(string $key)
    {
        return Arr::get(config('auth0'), $key);
    }
}
