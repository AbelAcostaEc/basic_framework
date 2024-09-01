<?php

namespace App\Controllers;

use Asaa\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {

        $data = [
            'test' => 'test',
        ];
        $this->render('index', $data);
    }
}
