<?php

// Home Page
$router->get('/', 'HomeController@index');

// Listing Display Routes
$router->get('/listings', 'ListingsController@index');
$router->get('/listings/create', 'ListingsController@create', ['auth']);
$router->get('/listings/search', 'ListingsController@search');
$router->get('/listings/{id}', 'ListingsController@show');
$router->get('/listings/{id}/edit', 'ListingsController@edit', ['auth']);

// Listing CRUD Routes
$router->post('/listings', 'ListingsController@store', ['auth']);
$router->put('/listings/{id}', 'ListingsController@update', ['auth']);
$router->delete('/listings/{id}', 'ListingsController@destroy', ['auth']);

// Authentication Display Routes
$router->get('/register', 'UserController@register', ['guest']);
$router->get('/login', 'UserController@login', ['guest']);

// Authentication CRUD Routes
$router->post('/register', 'UserController@store', ['guest']);
$router->post('/login', 'UserController@authenticate', ['guest']);
$router->post('/logout', 'UserController@logout', ['auth']);
