<?php

$router->group(
    ['prefix' => 'installer'],
    function ($router) {
        $router->post('update',  'UpdateController@update_init');
        $router->get('update', 'UpdateController@update');
        $router->post('/', 'DatabaseController@post');
        $router->get('/', 'HomeController@index');
    }
);
