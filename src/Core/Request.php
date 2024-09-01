<?php

namespace Asaa\Core;

class Request
{
    protected $post;
    protected $get;
    protected $files;
    protected $server;

    public function __construct()
    {
        $this->post = $this->sanitize($_POST);
        $this->get = $this->sanitize($_GET);
        $this->files = $_FILES;
        $this->server = $_SERVER;
    }

    protected function sanitize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitize($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }

    public function getPost($key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }

    public function getAllPost()
    {
        return $this->post;
    }

    public function getFile($key)
    {
        return $this->files[$key] ?? null;
    }

    public function getAllFiles()
    {
        return $this->files;
    }

    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function getPath()
    {
        $path = $this->server['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    public function getAllGet()
    {
        return $this->get;
    }

    public function getGet($key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    public function isAjax()
    {
        return isset($this->server['HTTP_X_REQUESTED_WITH']) && $this->server['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public function getJson()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}
