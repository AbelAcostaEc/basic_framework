<?php

use Asaa\Core\Request;
use Asaa\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar configuración
$config = require '../config/config.php';

// Definir variables globales dinámicamente
foreach ($config as $key => $value) {
    // Verifica si el valor es un array (para evitar definir demasiadas constantes)
    if (is_array($value)) {
        // Puedes manejar configuraciones anidadas aquí si lo necesitas
        foreach ($value as $subKey => $subValue) {
            define(strtoupper("{$key}_{$subKey}"), $subValue);
        }
    } else {
        define(strtoupper($key), $value);
    }
}

// Crear una instancia del enrutador
$router = new Router();

// Cargar rutas web
// Cargar rutas desde el archivo web.php
$routeLoader = require_once __DIR__ . '/../routes/web.php';

// Pasar la instancia del enrutador a la función cargada
$routeLoader($router);

$request = new Request();
$router->dispatch($request);
