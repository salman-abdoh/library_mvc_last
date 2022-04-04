<?php
require_once __DIR__ . '/../vendor/autoload.php';

use coding\app\controllers\AuthorsController;
use coding\app\controllers\BooksController;
use coding\app\controllers\PuplisherController;
use coding\app\controllers\addressController;
use coding\app\controllers\CategoriesController;
use coding\app\controllers\OffersController;
use coding\app\controllers\PublishersController;
use coding\app\system\AppSystem;
use coding\app\system\Router;
use coding\app\controllers\UsersController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));//createImmutable(__DIR__);
$dotenv->load();

$config=array(
  'servername'=>$_ENV['DB_SERVER_NAME'],
  'dbname'=>$_ENV['DB_NAME'],
  'dbpass'=>$_ENV['DB_PASSWORD'],
  'username'=>$_ENV['DB_USERNAME']

);
$system=new AppSystem($config);

/** web routes  */
Router::get('/dashbord/authors',[AuthorsController::class,'listAll']);
Router::get('/dashbord/add_authors',[AuthorsController::class,'create']);
Router::post('/save_authors',[AuthorsController::class,'store']);

Router::get('/dashbord/puplisher',[PuplisherController::class,'listAll']);
Router::get('/dashbord/add_puplisher',[PuplisherController::class,'create']);
Router::post('/save_puplisher',[PuplisherController::class,'store']);

Router::get('/dashbord/address',[AddressController::class,'listAll']);
Router::get('/dashbord/add_adress',[AddressController::class,'create']);
Router::post('/save_address',[AddressController::class,'store']);

Router::get('/dashbord/books',[BooksController::class,'listAll']);
Router::get('/dashbord/add_book',[BooksController::class,'create']);
Router::post('/save_book',[BooksController::class,'store']);
Router::get('/dashbord/edit_book/{id}',[BooksController::class,'edit']);
Router::post('/update_book',[BooksController::class,'update']);
Router::post('/status_book',[BooksController::class,'remove']);

Router::get('/dashbord/categories',[CategoriesController::class,'listAll']);
Router::get('/dashbord/add_category',[CategoriesController::class,'create']);
Router::get('/dashbord/edit_category/{id}',[CategoriesController::class,'edit']);
// Router::get('/dashbord/remove_category/{id}/{name}',[CategoriesController::class,'remove']);
Router::post('/status_category',[CategoriesController::class,'remove']);
Router::post('/save_category',[CategoriesController::class,'store']);
Router::post('/update_category',[CategoriesController::class,'update']);
/** offer routes  */

Router::get('/dashbord/offers',[OffersController::class,'listAll']);
Router::get('/dashbord/add_offer',[OffersController::class,'create']);
Router::get('/edit_offer/{id}',[OffersController::class,'edit']);
Router::get('/remove_offer/{id}/{name}',[OffersController::class,'remove']);
Router::post('/save_offer',[OffersController::class,'store']);
Router::post('/dashbord/update_offer',[OffersController::class,'update']);

/** end of web routes */



$system->start();

