<?php

namespace App\Modules;

use \Symfony\Component\HttpFoundation;

class Request
{
    private $request;
    private $params;

    public function __construct()
    {
        $this->request = HttpFoundation\Request::createFromGlobals();
        $this->params = array_merge($this->request->request->all(), $this->request->query->all());
    }

    public function get()
    {
        return $this->request;
    }

    public function getParams($key = null)
    {
        if ($key == null) {
            return $this->params;
        }
        return @$this->params[$key];
    }
}
