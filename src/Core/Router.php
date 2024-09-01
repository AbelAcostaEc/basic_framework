<?php

namespace Asaa\Core;

use Asaa\Core\Request;

class Router
{
    // Almacena las rutas registradas en el router
    protected $routes = [];

    /**
     * Agrega una nueva ruta al router.
     *
     * @param string $method El método HTTP para esta ruta (GET, POST, etc.).
     * @param string $path La ruta de la solicitud (por ejemplo, /home).
     * @param mixed $handler El controlador o la función que manejará la solicitud.
     * @return void
     */
    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method), // Convertir el método a mayúsculas para normalizar
            'path' => $path,
            'handler' => $handler,
        ];
    }

    /**
     * Despacha la solicitud a la ruta correspondiente.
     *
     * @param Request $request La instancia de la solicitud que contiene los datos de la solicitud.
     * @return void
     */
    public function dispatch(Request $request)
    {
        // Itera sobre todas las rutas registradas
        foreach ($this->routes as $route) {
            // Compara el método HTTP y la ruta solicitada con los datos de la solicitud
            if ($route['method'] == $request->getMethod() && $route['path'] == $request->getPath()) {
                // Si el controlador es una función callable, lo ejecuta
                if (is_callable($route['handler'])) {
                    call_user_func($route['handler'], $request);
                } 
                // Si el controlador es un array con el formato [controlador, método]
                elseif (is_array($route['handler']) && count($route['handler']) === 2) {
                    $controller = $route['handler'][0]; // Nombre del controlador
                    $method = $route['handler'][1]; // Método del controlador
                    $this->handleController($controller, $method, $request);
                }
                return; // Detenemos la ejecución después de encontrar y manejar una ruta válida
            }
        }

        // Si ninguna ruta coincide, se envía un error 404
        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Maneja la solicitud al controlador y al método especificado.
     *
     * @param string $controller Nombre del controlador.
     * @param string $method Nombre del método en el controlador.
     * @param Request $request La instancia de la solicitud.
     * @return void
     */
    protected function handleController($controller, $method, $request)
    {
        // Verifica si la clase del controlador existe
        if (class_exists($controller)) {
            $controllerInstance = new $controller; // Crea una instancia del controlador
            // Verifica si el método existe en el controlador
            if (method_exists($controllerInstance, $method)) {
                call_user_func([$controllerInstance, $method], $request); // Llama al método del controlador
                return; // Detenemos la ejecución después de manejar el controlador
            }
        }

        // Si el controlador o el método no existen, se envía un error 404
        http_response_code(404);
        echo "Controller or method not found";
    }
}
