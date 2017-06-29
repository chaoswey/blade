<?php

if (!function_exists('url')) {
    function url($path = "/")
    {
        $url = new \App\Url();
        return $url->get($path);
    }
}

if (!function_exists('asset')) {
    function asset($content = null)
    {
        $url = new \App\Url();
        return $url->asset($content);
    }
}

if (!function_exists('url_is')) {
    function url_is($url, $class = "active")
    {
        $request = new \App\Request();
        if ($request->is($url)) {
            return $class;
        }
        return "";
    }
}

if (!function_exists('faker')) {
    function faker($locale = 'zh_TW')
    {
        $faker = Faker\Factory::create($locale);
        return $faker;
    }
}

if (!function_exists('image')) {
    function image($width = 640, $height = 480, $type = "business", $text = null)
    {
        $faker = Faker\Factory::create();
        return $faker->imageUrl($width, $height, $type, true, $text);
    }
}