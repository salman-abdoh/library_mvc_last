<?php
namespace coding\app\controllers;

use coding\app\models\AUthor;

    class AuthorsController extends Controller{

        function listAll(){
            $auther=new AUthor();
            $allauther=$auther->getAll();
            //print_r($allCategories);
    
            $this->view('/dashbord/list_authors',$allauther);
    
        }
        function create(){
            $this->view('/dashbord/add_authors');
    
        }
    
        function store(){
            print_r($_POST);
            print_r($_FILES);
            $auther=new AUthor();
            
            $auther->name=$_POST['auther_name'];
            $auther->phone=$_POST['auther_phone'];
            $auther->email=$_POST['auther_email'];
            $auther->bio=$_POST['auther_bio'];
            $auther->is_active=$_POST['is_active'];
    
            $auther->save();
    
        }
        function edit(){
            
    
        }
        function update(){
    
        }
        public function remove(){
    
        }
    
    
      
        
    
    
    
    
    }
?>