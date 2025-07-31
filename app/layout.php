<?php

class Layout
{
    public static function getHeader()
    {
        include APP_PATH . '/views/layout/header.php';
    }

    public static function getBottom()
    {
        include APP_PATH . '/views/layout/footer.php';
    }
}
