<?php

/*
* App Core Class
* Creates URl & loads Core Controller
* URL format - / Controller / Method / Params
*/

class Core{
    protected $currentController = 'Pages';
    protected $currentMethod     = 'index';
    protected $params            = [];

    public function __construct(){
        $url = $this->getUrl();
          
        //Look in Controllers For first Value $url[0]
        if(file_exists('../app/controllers/'.ucwords($url[0]) .'.php')){
            //If Exist Set as Controller
            $this->currentController = ucwords($url[0]);
            //unset 0 index
            unset($url[0]);
        }

        //require the controller
        require_once '../app/controllers/' . $this->currentController .'.php';
        // Instantiate Controller Class
        $this->currentController = new $this->currentController;
///////////////////////////////////////
        // check for second part of url
        if(isset($url[1])){
            // check to see if method exist in controller
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                //unset 1 index
                unset($url[1]);
            }
        } 
///////////////////////////////////////
        // Get Params
        $this->params = $url ? array_values($url) : [];
        // call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod],$this->params);

    }
    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}