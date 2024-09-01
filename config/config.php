<?php

return [
    'base_path' => dirname(__DIR__) . '/',
    'public_path' => dirname(__DIR__) . '/public',
    'view_path' => dirname(__DIR__) . '/resources/views',
    'default_route' => '/', // Ruta por defecto
    'db' => [
        'host' => 'localhost',
        'dbname' => 'my_database',
        'user' => 'root',
        'password' => '',
    ],
    // Puedes añadir más configuraciones aquí
];
