<?php

namespace coding\app\controllers;

use coding\app\models\Category;

class CategoriesController extends Controller{

    function listAll($parameters=null){

        $parameters['status'];
        $categories=new Category();
        $allCategories=$categories->getAll();
        //print_r($allCategories);

        $this->view('/dashbord/list_categories',$allCategories);

    }
    function create(){
        $this->view('/dashbord/add_category');

    }

    function store(){
        print_r($_POST);
        print_r($_FILES);
        $category=new Category();
        
        $category->name=$_POST['category_name'];
        $imageName=$this->uploadFile($_FILES['image']);

        $category->image=$imageName!=null?$imageName:"default.png";
        $category->created_by=1;
        $category->is_active=$_POST['is_active'];

        $category->save();
        header('Location: http://localhost:8000/dashbord/categories');

    }
    function edit($params=[]){

        $categories = new Category();
       
        $category = $categories->getSingleRow($params['id']);
        $viewConent = array(
            
            'categories' => $category
        );
        $this->view('/dashbord/edit_category', $viewConent);
        

    }
    function update(){
         
        $category = new Category();

        $arr ="name='" . $_POST['category_name'] . "',is_active =" . $_POST['is_active'];
        $category->update($arr, $_POST['category_id']);
        header('Location: http://localhost:8000/dashbord/categories');

    }
    public function remove(){
        $category = new Category();

        $arr = "is_active = " . $_POST['is_active'];
        $category->update($arr, $_POST['category_id']);
        header('Location: http://localhost:8000/dashbord/categories');
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