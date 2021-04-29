<?php

if (!file_exists(__DIR__ . "/.ini"))
    copy(__DIR__ . "/.ini.example", __DIR__ . "/.ini");

require __DIR__ . "/vendor/autoload.php";

define("__CONFIG", parse_ini_file(__DIR__ . "/.ini", true));

require __DIR__ . "/config/database.php";

require __DIR__ . "/config/routes.php";

