<?php

namespace Asaa\Core;

use Asaa\Views\View;

class Controller
{

    public function render($view, $data = [])
    {
        View::render($view, $data);
    }
}
