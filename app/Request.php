<?php

namespace App;

class Request
{
    public $server;

    public $get;

    public $post;

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
        return file_get_contents('php://input');
    }
}
