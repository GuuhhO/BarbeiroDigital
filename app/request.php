<?php

class Request
{
    public static $_get;

    public static function getParameter($key)
    {
        self::$_get = $_GET;
        return $_GET[$key] ?? null;
    }
}