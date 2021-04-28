<?php

if (!file_exists(__DIR__ . "/../.ini"))
    copy(__DIR__ . "/../.ini.example", __DIR__ . "/../.ini");

define("__CONFIG", parse_ini_file(__DIR__ . "/../.ini", true));

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../config/routes.php";


/** Вывод результата */
function response($response) {
    echo $response;
}

method_exists($response, 'send') ? $response->send() : response($response);