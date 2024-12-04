<?php
// app/Helpers/Toast.php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class Toast
{
    public static function success($message)
    {
        self::addToast('success', $message);
    }

    public static function error($message)
    {
        self::addToast('error', $message);
    }

    public static function info($message)
    {
        self::addToast('info', $message);
    }

    public static function warning($message)
    {
        self::addToast('warning', $message);
    }

    protected static function addToast($type, $message)
    {
        Session::flash('toast', [
            'type' => $type,
            'message' => $message,
        ]);
    }
}
