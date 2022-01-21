<?php

use Illuminate\Support\Facades\Auth;

return [
    'login'=> 'ورود',
    'register' => 'ثبت نام',
    'register & login system' => 'سیستم ثبت نام و ورود',
    'practical laravel' => 'لاراول کاربردی',
    'main page' => Auth::user() ? ' پنل مدریت'. " : " . Auth::user()->name : 'خانه '


];
