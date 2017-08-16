<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

require 'config.php';
require 'core/Database.php';
$core = new Core\Database();
?>