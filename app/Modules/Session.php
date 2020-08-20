<?php

namespace App\Modules;

use \Symfony\Component\HttpFoundation;
use \Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class Session
{
    const KEY_LOGIN = 'login';
    
    private static $session = null;
    
    private function __construct()
    {
    }
    
    public static function start()
    {
        if (self::$session === null) {
            $sessionStorage = new NativeSessionStorage([], new NativeFileSessionHandler());
            self::$session = new HttpFoundation\Session\Session($sessionStorage);
            self::$session->start();
        }
    }
    
    public static function set($key, $value)
    {
        self::start();
        return self::$session->set($key, $value);
    }
    
    public static function get($key)
    {
        self::start();
        return self::$session->get($key);
    }
    
    public static function invalidate()
    {
        self::start();
        return self::$session->invalidate();
    }
    
    public static function getInstance()
    {
        self::start();
        return self::$session;
    }
    
    public static function isLogged()
    {
        $login = (string)Session::get(Session::KEY_LOGIN);
        
        if ($login == "") {
            return false;
        }
        
        return true;
    }
}
