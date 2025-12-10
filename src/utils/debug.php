<?php

function server_log(string $message) {
    file_put_contents(__DIR__ . "/../../logs/php_debug.log", "[" . date(DATE_RFC3339_EXTENDED) . "] <LOG>  $message\n", FILE_APPEND);
}

function server_error(string $message) {
    file_put_contents(__DIR__ . "/../../logs/php_errors.log", "[" . date(DATE_RFC3339_EXTENDED) . "] <LOG>  $message\n", FILE_APPEND);
}


?>