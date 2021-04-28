<?php

use Illuminate\Database\Capsule\Manager;

$database = new Manager;

$database->addConnection([
    'driver' => __CONFIG['database']['driver'] ?? "mysql",
    'host' => __CONFIG['database']['host'] ?? "127.0.0.1",
    'database' => __CONFIG['database']['database'] ?? "dbname",
    'username' => __CONFIG['database']['username'] ?? "root",
    'password' => __CONFIG['database']['password'] ?? "",
    'charset' => "utf8",
    'collation' => "utf8_unicode_ci",
]);

$database->bootEloquent();