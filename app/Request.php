<?php

namespace App;

class Request
{
    public $server;

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function getMethod()
    {
        return strtolower($this->server['REQUEST_METHOD']);
    }

    public function getBody()
    {
    }
}
