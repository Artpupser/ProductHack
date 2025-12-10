<?php

namespace ProductHack\core;

class Response
{
    public function __construct()
    {
        
    }

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
}