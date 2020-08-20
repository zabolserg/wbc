<?php

namespace App\Controllers;

use \App\Modules\Response;
use \App\Modules\Request;
use \App\Modules\Session;
use \App\Views;

class DefaultController
{
    public static function index()
    {
        if (Session::isLogged()) {
            $response = new Response('');
            $response->redirect('/admin');
        }

        if (count($_POST) > 0) {
            $request = new Request();
            $data = $request->getParams();

            //TODO replace hardcode with Doctrine Entity
            if (@$data['login'] == 'test' && @$data['password'] == 'test') {
                Session::set(Session::KEY_LOGIN, 'test');
                $response = new Response('');
                $response->redirect('/admin');
                return $response;
            } else {
                return new Response(
                    json_encode([
                        'success' => false,
                        'error' => 'User not found'
                    ]), 404, ["type" => Response::TYPE_JSON]
                );
            }
        }

        return new Response(new Views\Load('index'));
    }

    public static function notFound()
    {
        return new Response(new Views\Load('404'), 404);
    }

    public static function admin()
    {
        if (!Session::isLogged()) {
            $response = new Response('');
            $response->redirect('/');
        }

        if (count($_POST) > 0) {
            if ($_POST['logout'] == '1') {
                Session::invalidate();
                $response = new Response('');
                $response->redirect('/');
                return $response;
            }
        }

        return new Response(new Views\Load('admin'));
    }

}
