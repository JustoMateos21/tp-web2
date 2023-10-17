<?php

require_once './app/model/product.model.php';
require_once './app/view/product.view.php';
require_once './app/view/home.view.php';

class HomeController{

    private $productModel;
    private $categoryModel;

    private $view;

    private $loggedIn;

    public function __construct(){
        //AuthHelper::verify();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->view = new HomeView();
 
    }

    public function showHome(){
        $nameController = 'HOME';
        AuthHelper::verify($nameController);

        $products = $this->productModel->getProducts();
        $categories = $this->categoryModel->getCategory();
        $this->view->showHome($products, $categories);
 }
}
?>