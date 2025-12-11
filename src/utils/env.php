<?php

function load_env() {
    require_once "config.php";
    require_once ROOT_DIR . "/vendor/autoload.php";
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
    $dotenv->load();
}

?>