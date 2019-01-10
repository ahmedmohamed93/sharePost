<?php
 // default controller
 class Pages extends Controller{
     public function __construct(){
     
     }
     public function index(){  // default method 
        if(isLoggedIn()){
            redirect('posts');
        }
        //array of data
        $data = [
            "title" => 'SharePosts',
            "discription" => "Simple Soial Network Built on The AhmedMVC PHP Framework "
        ];
      $this->view("pages/index",$data);
    }

     public function about(){
        $data = ["title" => 'About US'];
        $this->view("pages/about",$data);
     }
 }