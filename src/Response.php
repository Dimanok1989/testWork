<?php

namespace Kolgaev;

use Symfony\Component\HttpFoundation\JsonResponse;
use Jenssegers\Blade\Blade;

class Response {

    /**
     * Вывод json
     * 
     * @param array|object $data
     * @param int $code
     * @return null
     */
    public static function json($data = [], $code = 200) {

        $response = new JsonResponse($data, $code);

        $response->send();

        return null;

    }

    /**
     * Вывод страницы
     * 
     * @param string $name
     * @param array $data
     * @return null
     */
    public static function view($name, $data = []) {

        $blade = new Blade('../views', '../cache');

        echo $blade->render($name, $data);

        return null;

    }

}