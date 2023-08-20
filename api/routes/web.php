<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(["prefix"=>"api/v1"],function () use ($router) {
    $router->get('users', 'UsersProvidersController@index');
});
