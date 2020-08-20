<?php

namespace App\Modules;

use \Symfony\Component\HttpFoundation;

class Response
{
    const URL_PREFIX = "/test-app";
    const TYPE_JSON = "json";

    private $response;

    public function __construct($html = null, $code = 200, $params = array())
    {
        $this->response = new HttpFoundation\Response($html, $code);

        if (isset($params['type'])) {
            if (in_array($params['type'], array(self::TYPE_JSON))) {
                switch ($params['type']) {
                    case self::TYPE_JSON:
                        $this->response->headers->set('Content-Type', 'application/json');
                        break;
                }
            }
        }

    }

    public function get()
    {
        return $this->response;
    }

    public function set($html)
    {
        $this->response->setContent($html);
    }

    public function send()
    {
        $this->response->send();
    }

    public function redirect($to)
    {
        $redirect = new HttpFoundation\RedirectResponse(self::URL_PREFIX . $to);
        $redirect->send();
    }
}
