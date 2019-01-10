<?php

 class Controller{
   /*
   * Base Controller
   * loads the Models And Views
   */

   // load models
   public function Model($model){
       //require model
       require_once '../app/models/'. $model .'.php';
       // instantiate model
       return new $model;
   }
   //load views
   public function View($view, $data=[]){
       // check for view file 
       if(file_exists('../app/views/'. $view . '.php')){
           // require view
           require_once '../app/views/'. $view .'.php';
       }else{
           // view does not exist
           die("View doesnt Exist");
       }
       
   }
    
 }