<?php
namespace coding\app\controllers;

use coding\app\models\Address;

    class AddressController extends Controller{

        function listAll(){
            $address=new Address();
            $alladdress=$address->getAll();
            //print_r($allCategories);
    
            $this->view('/dashbord/list_address',$alladdress);
    
        }
        function create(){
            $this->view('/dashbord/add_adress');
    
        }
    
        function store(){
            print_r($_POST);
            print_r($_FILES);
            $address=new address();
            
            $address->name=$_POST['address_name'];
          
            $address->is_active=$_POST['is_active'];
    
            $address->save();
    
        }
        function edit(){
            
    
        }
        function update(){
    
        }
        public function remove(){
    
        }
    
    
      
        
    
    
    
    
    }
?>