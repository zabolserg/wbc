<?php

namespace App\Modules;

use \Symfony\Component;

class Routing
{
    const CONFIG_NAME = 'routes.yml';

    private $request;
    private $matcher;

    public function __construct(\App\Modules\Request $request)
    {
        $this->request = $request->get();

        $configPath = realpath(__DIR__ . '/../Controllers/');

        $fileLocator = new Component\Config\FileLocator($configPath);
        $loader = new Component\Routing\Loader\YamlFileLoader($fileLocator);
        $routes = $loader->load(self::CONFIG_NAME);

        $context = new Component\Routing\RequestContext();
        $context->fromRequest($this->request);

        $this->matcher = new Component\Routing\Matcher\UrlMatcher($routes, $context);
    }

    public function callController()
    {
        $params = $this->matcher->match($this->request->getPathInfo());
        $call = explode('::', $params['_controller']);
        unset($params['_controller']);
        unset($params['_route']);
        return call_user_func_array(
            array(new $call[0](), $call[1]),
            $params
        );
    }
}
