<?php
namespace App\Core;
use App\Core\FilteredMap;

class Request
{
    private $domain;
    private $path;
    private $method;
    private $putOrDeleteData = [];
    private $params;
    private $cookies;

    public function __construct() 
    { 
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->path = $_SERVER['REQUEST_URI'];
        
        if ($_POST['_method']) {
            $this->method = $_POST['_method'];
        } else {
            $this->method = $_SERVER['REQUEST_METHOD'];
        }

        if ($this->method === 'PUT' || $this->method === 'DELETE') {
            parse_str(file_get_contents('php://input'), $this->putOrDeleteData);
        }

        $this->params = new FilteredMap(
            array_merge($_POST, $_GET, $this->putOrDeleteData)
        );

        $this->cookies = new FilteredMap($_COOKIE);
    }
    
    public function getUrl(): string
    {
        return $this->domain . $this->path;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParams(): FilteredMap
    {
        return $this->params;
    }

    public function getCookies(): FilteredMap
    {
        return $this->cookies;
    }
}