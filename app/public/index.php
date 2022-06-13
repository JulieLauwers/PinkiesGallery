<?php

require_once '../vendor/autoload.php';

session_start();

$router = new \Bramus\Router\Router();
$router->setNamespace('Http');

$router->get('/', 'PinkieController@showIndex');
$router->get('/about', 'PinkieController@showAbout');
$router->get('/404', 'PinkieController@show404');

$router->get('/gallery', 'GalleryController@showGallery');
$router->get('/gallery/(\d+)', 'GalleryController@showPhoto');
$router->post('/gallery/(\d+)/delete', 'GalleryController@deletePhoto');


$router->get('/contact', 'ContactController@overview');
$router->post('/contact', 'ContactController@overview');


$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@register');
$router->get('/profile', 'ProfileController@showProfile');


$router->get('/admin', 'AdminController@showAdmin');
$router->get('/admin/photo/add', 'AdminController@add');
$router->post('/admin/photo/add', 'AdminController@add');
$router->get('/admin/message/(\d+)', 'AdminController@detailMessage');
$router->post('/admin/message/(\d+)/delete', 'AdminController@deleteMessage');

$router->run();
?>