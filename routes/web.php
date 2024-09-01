<?php

use App\Controllers\HomeController;

return function ($router) {
    $router->add('GET', '/', [HomeController::class, 'index']);
    $router->add('GET', '/test', [HomeController::class, 'test']);
    $router->add('POST', '/testPost', [HomeController::class, 'test']);
    // Agrega más rutas aquí
};
