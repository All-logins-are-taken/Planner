<?php

declare(strict_types=1);

namespace App\Http;

class Router
{
    public static function get($route, $callback): void
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') !== 0) {
            return;
        }
        self::on($route, $callback);
    }

    public static function post($route, $callback): void
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') !== 0) {
            return;
        }
        self::on($route, $callback);
    }

    public static function on($expression, $callback): void
    {
        $parameters = $_SERVER['REQUEST_URI'];
        $parameters = (stripos($parameters, "/") !== 0) ? "/" . $parameters : $parameters;
        $expression = str_replace('/', '\/', $expression);
        $matched = preg_match('/^' . ($expression) . '$/', $parameters, $isMatched, PREG_OFFSET_CAPTURE);

        if ($matched) {
            array_shift($isMatched);

            $parameters = array_map(function ($parameter) {
                return $parameter[0];
            }, $isMatched);

            $callback(new Request($parameters), new Response());
        }
    }
}
