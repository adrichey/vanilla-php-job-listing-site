<?php

// Home Page
$router->get('/', 'HomeController@index');

// Listing Display Routes
$router->get('/listings', 'ListingsController@index');
$router->get('/listings/create', 'ListingsController@create');
$router->get('/listings/{id}', 'ListingsController@show');
$router->get('/listings/{id}/edit', 'ListingsController@edit');

// Listing CRUD Routes
$router->post('/listings', 'ListingsController@store');
$router->put('/listings/{id}', 'ListingsController@update');
$router->delete('/listings/{id}', 'ListingsController@destroy');

// Authentication Display Routes
$router->get('/register', 'UserController@register');
$router->get('/login', 'UserController@login');

// Authentication CRUD Routes
$router->post('/register', 'UserController@store');
$router->post('/login', 'UserController@authenticate');
$router->post('/logout', 'UserController@logout');
