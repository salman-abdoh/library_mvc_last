<?php
namespace coding\app\controllers;

use coding\app\models\Puplisher;

    class PuplisherController extends Controller{

        function listAll(){
            $puplisher=new Puplisher();
            $allpuplisher=$puplisher->getAll();
            //print_r($allCategories);
    
            $this->view('/dashbord/list_puplisher',$allpuplisher);
    
        }
        function create(){
            $this->view('/dashbord/add_puplisher');
    
        }
    
        function store(){
            print_r($_POST);
            print_r($_FILES);
            $puplisher=new Puplisher();
          
            $puplisher->name=$_POST['puplisher_name'];
            $puplisher->phone=$_POST['puplisher_phone'];
            $puplisher->alt_phone=$_POST['puplisher_alt_phone'];
            $puplisher->fax=$_POST['puplisher_fax'];
            $puplisher->email=$_POST['puplisher_email'];
            $puplisher->address=$_POST['puplisher_address'];
            $puplisher->country=$_POST['puplisher_country'];
            $imageName=$this->uploadFile($_FILES['image']);

            $puplisher->image=$imageName!=null?$imageName:"default.png";
            $puplisher->is_active=$_POST['is_active'];
    
            $puplisher->save();
    
        }
        function edit(){
            
    
        }
        function update(){
    
        }
        public function remove(){
    
        }
    
    
        public static function uploadFile(array $imageFile): string
        {
            // check images direction
            if (!is_dir(__DIR__ . '/../../public/images')) {
                mkdir(__DIR__ . '/../../public/images');
            }
    
            if ($imageFile && $imageFile['tmp_name']) {
                $image = explode('.', $imageFile['name']);
                $imageExtension = end($image);
    
                $imageName = uniqid(). "." . $imageExtension;
                $imagePath =  __DIR__ . '/../../public/images/' . $imageName;
    
                move_uploaded_file($imageFile['tmp_name'], $imagePath);
    
                return $imageName;
            }
    
            return null;
        }
      
        
    
    
    
    
    }
?>