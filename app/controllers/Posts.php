<?php
 
 class Posts extends Controller{
     public function __construct(){
         if(!isLoggedIn()){
             redirect('users/login');
         }
         
         $this->postModel = $this->Model('Post');
         $this->userModel = $this->Model('User');
        
     }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function index(){
         $posts = $this->postModel->getPost();
         // init data
         $data = [
             'posts' =>$posts
         ];
         $this->view('posts/index', $data);
     }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function add(){
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
             // sanitize post array
             $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
             // init data
             $data = [
                'title'     => trim($_POST['title']),
                'body'      => trim($_POST['body']),
                'user_id'   => $_SESSION['user_id'],
                'title_err' => '',
                'body_err'  => ''
             ];

             // Validate data
             if(empty($data['title'])){
                 $data['title_err'] = 'Please Enter Title';
             }
             if(empty($data['body'])){
                $data['body_err'] = 'Please Enter Body';
            }

            // Make Sure No errors
            if(empty($data['title_err']) && empty($data['body_err'])){
                // validated
                if($this->postModel->addPost($data)){
                    flash('post_message', 'Post Added Successfully');
                    redirect('posts');
                }else{
                    die('something Went wrong');
                }
            }else{
                // load view with errors
                $this->view('posts/add', $data);
            }
             
         }else{
             // init data
             $data = [
                    'title' => '',
                    'body'  => ''
             ];
             $this->view('posts/add', $data);
         }
         
     }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function edit($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // init data
            $data = [
               'id'        => $id,
               'title'     => trim($_POST['title']),
               'body'      => trim($_POST['body']),
               'user_id'   => $_SESSION['user_id'],
               'title_err' => '',
               'body_err'  => ''
            ];

            // Validate data
            if(empty($data['title'])){
                $data['title_err'] = 'Please Enter Title';
            }
            if(empty($data['body'])){
               $data['body_err'] = 'Please Enter Body';
           }

           // Make Sure No errors
           if(empty($data['title_err']) && empty($data['body_err'])){
               // validated
               if($this->postModel->updatePost($data)){
                   flash('post_message', 'Post Updated Successfully');
                   redirect('posts');
               }else{
                   die('something Went wrong');
               }
           }else{
               // load view with errors
               $this->view('posts/edit', $data);
           }
            
        }else{
            $post = $this->postModel->getPostById($id);
            //check For Owner
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            // init data
            $data = [
                   'id'    => $id,
                   'title' => $post->title,
                   'body'  => $post->body
            ];
            $this->view('posts/edit', $data);
        }
        
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function delete($id){
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $post = $this->postModel->getPostById($id);
            //check For Owner
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
             if($this->postModel->deletePost($id)){
                flash('post_message', 'Post Deleted Successfully');
                redirect('posts');
             }else{
                die('something Went wrong');
             }
         }else{
             redirect('posts');
         }
     }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

     public function show($id){
         $post = $this->postModel->getPostById($id);
         $user = $this->userModel->getUserById($post->user_id);
         $data=[
             'post' => $post,
             'user' => $user
         ];
         $this->view('posts/show', $data);
     }

 }