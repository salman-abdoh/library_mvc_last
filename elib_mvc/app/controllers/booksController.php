<?php

namespace coding\app\controllers;

use coding\app\models\AUthor;
use coding\app\models\Books;
use coding\app\models\Category;
use coding\app\models\Model;
use coding\app\system\AppSystem;
use coding\app\models\Puplisher;
use  coding\app\system\Database;

class BooksController extends Controller
{

    function listAll()
    {
        $book = new Books();
        $allbook = $book->getAll();
        //print_r($allCategories);
        $sql = 'select *,
            (select categories.name from categories where categories.id=books.category_id) as cat_name,
            (select name from publishers where publishers.id=books.publisher_id) as book_pub,
            (select name from authors where authors.id=books.author_id) as book_auth 
                  from books';
        $Model = new Model();
        $stm = AppSystem::$appSystem->database->pdo->prepare($sql);
        $stm->execute();
        $allBooks = $stm->fetchAll();

        $this->view('/dashbord/listbook', $allBooks);
    }
    function listFilter($cat_id)
    {
      
        $book = new Books();
        $allbook = $book->getAll();
        //print_r($allCategories);
        $sql = 'select *,
            (select categories.name from categories where categories.id=books.category_id) as cat_name,
            (select name from publishers where publishers.id=books.publisher_id) as book_pub,
            (select name from authors where authors.id=books.author_id) as book_auth 
                  from books where category_id='.$cat_id;
        $Model = new Model();
        $stm = AppSystem::$appSystem->database->pdo->prepare($sql);
        $stm->execute();
        $allBooks = $stm->fetchAll();

        $this->view('/dashbord/listbook', $allBooks);
    }
    function create()
    {
        $categories = new Category(0);
        $cats = $categories->getAll();
        $authers = new AUthor(0);
        $auth = $authers->getAll();
        $puplisher = new Puplisher(0);
        $pupil = $puplisher->getAll();
        $viewConent = array('authers' => $auth, 'categories' => $cats, 'publishers' => $pupil);
        $this->view('/dashbord/add_book', $viewConent);
    }

    function store()
    {
        print_r($_POST);
        print_r($_FILES);
        $imageName = $this->uploadFile($_FILES['image']);
        $book = new Books();

        $book->title = $_POST['book_name'];
        $book->image = $imageName != null ? $imageName : "default.png";
        $book->price = $_POST['book_price'];
        $book->description = $_POST['book_descr'];
        $book->pages_number = $_POST['book_page'];
        $book->category_id = $_POST['selected_cats'];
        $book->author_id = $_POST['selected_auth'];
        $book->publisher_id = $_POST['selected_pup'];
        $book->quantity = $_POST['book_qyt'];
        $book->format = $_POST['book_format'];
        $book->is_active = $_POST['is_active'];
        $book->save();
        header('Location: http://localhost:8000/dashbord/books');
    }
    function edit($params = [])
    {

        $categories = new Category(0);
        $cats = $categories->getAll();
        $authers = new AUthor(0);
        $auth = $authers->getAll();
        $puplisher = new Puplisher(0);
        $pupil = $puplisher->getAll();
        $books = new Books();
        $book = $books->getSingleRow($params['id']);
        $viewConent = array(
            'authers' => $auth,
            'categories' => $cats,
            'publishers' => $pupil,
            'book' => $book
        );
        $this->view('/dashbord/edit_book', $viewConent);
    }
    function update()
     {
    //     print_r($_POST);
    //     print_r($_FILES);
        /*  if($_POST['image'] !=''){
        $imageName = $this->uploadFile($_FILES['image']);
        }else{
            $imageName ="";
        }*/
        $book = new Books();

        $arr = "title='" . $_POST['book_name'] . "',price =" . $_POST['book_price'] . ",description ='" . $_POST['book_descr'] . "',pages_number =" . $_POST['book_page'] .
            ',category_id = ' . $_POST['selected_cats'] . ',author_id = ' . $_POST['selected_auth'] . ',publisher_id = ' . $_POST['selected_pup'] . ',quantity =' . $_POST['book_qyt'] .
            ',format="' . $_POST['book_format'] . '",is_active = ' . $_POST['is_active'];
        $book->update($arr, $_POST['book_id']);
        header('Location: http://localhost:8000/dashbord/books');
    }
    public function remove()
    {
        //  print_r($_POST);

        $book = new Books();

        $arr = "is_active = " . $_POST['is_active'];
        $book->update($arr, $_POST['book_id']);
        header('Location: http://localhost:8000/dashbord/books');
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

            $imageName = uniqid() . "." . $imageExtension;
            $imagePath =  __DIR__ . '/../../public/images/' . $imageName;

            move_uploaded_file($imageFile['tmp_name'], $imagePath);

            return $imageName;
        }

        return null;
    }
}
