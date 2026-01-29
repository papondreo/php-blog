<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\ArticleController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/category/{slug}', [CategoryController::class, 'show']);
$router->get('/article/{slug}', [ArticleController::class, 'show']);

$router->dispatch();

