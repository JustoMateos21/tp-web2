<?php
        require_once 'app/model/model.php';



class ProductModel extends Model
{ 

    //This function gets from the database ALL PRODUCTS
    public function getProducts()
    {
        $query = $this->db->prepare('SELECT * FROM PRODUCT');
        $query->execute();

        // Fetch all rows from the query result
        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }


    public function getProductsByCategory($category_id) {
        $query = 'SELECT * FROM PRODUCT';
    
        if (is_numeric($category_id)) {
            $query .= ' WHERE category_id = ?';
        }
    
        $params = is_numeric($category_id) ? [$category_id] : [];
    
        $query = $this->db->prepare($query);
        $query->execute($params);
    
         $products = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $products;
    }
    

    public function getProductById($product_id){
        $query = 'SELECT * FROM PRODUCT WHERE product_id = ?';
        $params = is_numeric($product_id) ? [$product_id] : [0]; // Use 0 as a placeholder when $product_id is not numeric.
        $query = $this->db->prepare($query);
        $query->execute($params);
    
        $product = $query->fetch(PDO::FETCH_OBJ);
    
        return $product;
    }
    
    function insertProduct( $title, $description, $price, $brand, $image_url, $category_id, $image_file){
        $stock = 10;
        $query = $this->db->prepare('INSERT INTO product (name, description, brand, price, stock_quantity , category_id,image_url, image_file) VALUES(?,?,?, ?, ?, ?, ?, ?)');
     $query->execute([$title, $description, $brand, $price, $stock, $category_id, $image_url, $image_file]);
     return $this->db->lastInsertId();
    }




    function updateProduct($product_id,  $title, $description, $brand, $price, $stock, $category_id, $image_url, $image_file ){
        $query = $this->db->prepare('UPDATE product 
        SET name = ?, description = ?,  brand = ?, price = ?, stock_quantity= ?, category_id = ?, image_url = ?, image_file = ?
        WHERE product_id = ?');
        $query->execute([ $title, $description, $brand, $price, $stock, $category_id, $image_url, $image_file, $product_id]);
        return $query;
    }
  

    function deleteProductById($product__id){   
      $query= $this->db->prepare('DELETE FROM product WHERE product_id = ?');
      $query->execute([$product__id]);
      return $query;
    }

    function deleteAllProductsByCategory($category_id){
        $query = $this->db->prepare('DELETE FROM products where category_id = ?');
        $query->execute([$category_id]);
    }

}




?>