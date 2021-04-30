<?php

if (!file_exists(__DIR__ . "/.ini")) {
    require __DIR__ . "/views/errors/noini.php";
    die();
}

if (!file_exists(__DIR__ . "/cache")) {
    mkdir(__DIR__ . "/cache", 0777, true);
}

require __DIR__ . "/vendor/autoload.php";

define("__CONFIG", parse_ini_file(__DIR__ . "/.ini", true));

require __DIR__ . "/config/database.php";

require __DIR__ . "/config/routes.php";

