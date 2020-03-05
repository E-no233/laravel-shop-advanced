<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function ngrok_url($routeName, $parameters = [])
{
    $url = config('app.ngrok_url');
    // 开发环境，并且配置了 NGROK_URL
    if ($url && app()->environment('local')) {
        // route() 函数第三个参数代表是否绝对路径
        return $url . route($routeName, $parameters, false);
    }
    return route($routeName, $parameters);
}
