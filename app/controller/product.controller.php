<?php

require_once './app/model/product.model.php';

require_once './app/model/category.model.php';

require_once './app/view/product.view.php';
require_once './app/view/home.view.php';

class ProductController
{

    private $productModel;
    private $homeView;
    private $productView;

    private $categoryModel;

    public function __construct()
    {
        $nameController = 'PRODUCT';
        AuthHelper::verify($nameController);
         $this->productModel = new ProductModel();
        $this->productView = new ProductView();
        $this->categoryModel = new CategoryModel;
         $this->homeView = new HomeView();
     }


   public function showProducts() {
    $category = isset($_GET['category']) ? $_GET['category'] : null;
    $products= $this->productModel->getProductsByCategory($category);
    ///
    $categories = $this->categoryModel->getCategory(); //  
   ///
    $this->homeView->showHome($products, $categories);
}


public function showProductById() {
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
     $product = $this->productModel->getProductById($product_id);
    
    if ($product) {
        $this->productView->showProductById($product);
    } else {
        echo "Product not found.";
    }
}

public function submitProduct() {
    $nameController = 'PRODUCT';
    AuthHelper::verify($nameController);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $brand = $_POST['brand'];
        $category = $_POST['category'];
         $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $result = $this->productModel->insertProduct($name, $description, $price, $brand, '', $category, $imageData);
        if ($result) {
            header("Location: dashboard");
            exit;
        } else {
            echo "Product operation failed.";
        }
    }
}

public function putProduct() {
    $nameController = 'PRODUCT';
    AuthHelper::verify($nameController);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = isset($_GET['product-id']) ? $_GET['product-id'] : null;
        $name = $_POST['name'];
        $description = $_POST['description'];
        $brand = $_POST['brand'];
        $price = $_POST['price'];
        $stock = isset($_POST['stock']) ? $_POST['stock'] : null;
        $category = $_POST['category'];
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $result = $this->productModel->updateProduct($product_id, $name, $description, $brand, $price, $stock, $category, "", $imageData);
        if ($result) {
            header("Location: dashboard");
            exit;
        } else {
            echo "Product operation failed.";
        }
    }
}




 public function deleteProductById(){
    $nameController = 'PRODUCT';
    AuthHelper::verify($nameController);

    $productId = isset($_GET['product-id']) ? $_GET['product-id'] : null;

    if ($productId !== null) {
        $result = $this->productModel->deleteProductById($productId);
        if($result){
            header("Location: dashboard");
            exit;
        }else{
            echo "Product deletion failed.";
        }
    } 
 }

}

?>