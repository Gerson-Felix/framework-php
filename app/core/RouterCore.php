<?php

namespace app\core;

class RouterCore 
{
    private $uri;
    private $method;

    private $getArray = [];

    public function __construct()
    {
        $this->initialize();
        require_once('../app/config/Router.php');
        $this->execute();
    }

    private function initialize()
    {
        $this->method = $_SERVER["REQUEST_METHOD"];
        $uri = $_SERVER["REQUEST_URI"];

        $ex = explode('/', $uri);
        
        $uri = $this->normalizeURI($ex);

        for ($i = 0; $i < UNSET_URI_COUNT; $i++)
        {
            unset($uri[$i]);
        }

        $this->uri = implode('/', $this->normalizeURI($uri));
        // if (DEBUG_URI)
        //     dd($this->uri);
    }

    private function get ($router, $call)
    {
        $this->getArray[] = [
            'router' => $router,
            'call' => $call   
        ];   
    }

    private function normalizeURI ($array)
    {
        return array_values(array_filter($array));
    }

    private function execute()
    {
        switch ($this->method)
        {
            case 'GET':
                $this->executeGet();
            break;

            case 'POST':
                 
            break;
        }
    }

    private function executeGet()
    {
        foreach ($this->getArray as $get)
        {
            $router = substr($get['router'], 1);
            // echo $get['router'] .' - '. $this->uri . '<br>';

            if($router == $this->uri)
            {
                if (is_callable($get['call']))
                {
                    $get['call'](); 
                break;
                }
            }
        }
    }
}