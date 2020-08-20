<?php

namespace App\Views;

class Load
{
    private $response;

    public function __construct($name)
    {
        $file = __DIR__ . '/' . $name . '.html';
        if (file_exists($file)) {
            $this->response = file_get_contents($file);
        } else {
            $this->response = 'No view found';
        }
    }

    public function __toString()
    {
        return $this->response;
    }
}
