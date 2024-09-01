<?php

namespace Asaa\Views;

class View
{
    /**
     * Renderiza una vista con datos opcionales y un layout.
     *
     * @param string $view El nombre de la vista a renderizar (sin extensión).
     * @param array $data Datos a pasar a la vista.
     * @param string $layout El nombre del layout a usar (sin extensión). Por defecto es 'layout'.
     * @return void
     */
    public static function render($view, $data = [], $layout = 'layout')
    {
        // Construye la ruta completa al archivo de la vista
        $viewPath = VIEW_PATH . '/' . $view . '.php';

        // Construye la ruta completa al archivo del layout
        $layoutPath = VIEW_PATH . '/layouts/' . $layout . '.php';

        // Verifica si el archivo de la vista existe
        if (file_exists($viewPath)) {
            // Extrae las variables del array $data para que sean accesibles en la vista
            extract($data);

            // Capturamos el contenido de la vista usando el buffer de salida
            ob_start(); // Inicia el buffer de salida
            include $viewPath; // Incluye el archivo de la vista
            $content = ob_get_clean(); // Obtiene el contenido del buffer y limpia el buffer

            // Ahora cargamos el layout y pasamos el contenido capturado
            if (file_exists($layoutPath)) {
                // Si el archivo del layout existe, incluimos el layout
                include $layoutPath;
            } else {
                // Si el archivo del layout no existe, mostramos solo el contenido de la vista
                echo $content;
            }
        } else {
            // Si el archivo de la vista no existe, mostramos un mensaje de error
            // Extrae la ruta base de las vistas para mostrar en el mensaje de error
            $basePath = dirname(VIEW_PATH);

            // Construye la ruta relativa para el mensaje de error
            $relativePath = str_replace($basePath . '/', '', VIEW_PATH) . '/' . $view . '.php';
            echo "La vista '$view' no existe. Verifica la ruta: $relativePath";
        }
    }
}
