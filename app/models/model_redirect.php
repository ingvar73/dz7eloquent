<?php

class Model_Redirect extends Model
{
    public static function redirectToPage($path)
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = $path;
        header("Location: http://$host$uri/$extra");
        exit;
    }
}