<?php

namespace App\Http\Helpers\Traits\Web;

use Cookie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

trait CookieTrait
{
    public function setCookies($key,$value,$time)
    {
        return Cookie::queue(Cookie::make($key, $value, $time));
    }
    public function getCookies($key)
    {
        return Cookie::get($key);
    }

}
