<?php
    // load config
    require_once 'config/config.php';

    // load helper
    require_once 'helpers/url_helper.php';
    require_once 'helpers/session_helper.php';


    /*
    // Load Libraries
    require_once 'libraries/Controller.php';
    require_once 'libraries/Core.php';
    require_once 'libraries/Database.php';
    */


    // Autoload core Libraries
    spl_autoload_register(function($className){
        require_once 'libraries/'. $className . '.php';
    });

