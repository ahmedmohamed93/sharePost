<?php

 class User{
     private $db; 

     public function __construct(){
         $this->db = new Database;
     }

     public function register($data){
         $this->db->query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)" );
         //bind values
         $this->db->bind(':name', $data['name']);
         $this->db->bind(':email', $data['email']);
         $this->db->bind(':password', $data['password']);
         //execute
         if($this->db->execute()){
             return true;
         }else{
             return false;
         }
     }



     public function login($email, $password){
         $this->db->query('SELECT * FROM users WHERE email = :email');
         $this->db->bind(':email', $email);
         $row = $this->db->single();
         $hashed_password = $row->password;
         if(password_verify($password , $hashed_password)){
             return $row;
         }else{
             return false;
         }
     }

     

    // Get User By Email
     public function findEmailByUser($email){
         //find user by email
         $this->db->query('SELECT * FROM users WHERE email = :email');
         $this->db->bind(':email', $email);

         $row = $this->db->single();

         // check row
         if($this->db->rowCount() > 0){
             return true;
         }else{
             return false;
         }
     }


    // Get User By Id
     public function getUserById($id){
         //find user by email
         $this->db->query('SELECT * FROM users WHERE id = :id');
         $this->db->bind(':id', $id);

         $row = $this->db->single();

         return $row;
               
     }
 }