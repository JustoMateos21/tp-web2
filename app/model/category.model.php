
<?php
    require_once 'app/model/model.php';


class CategoryModel extends Model
{
    public function getCategory()
    {
        $query = $this->db->prepare('SELECT * FROM CATEGORY');
        $query->execute();

        $categories = $query->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }
    public function getCategoryById($category_id)
    {
        $query = $this->db->prepare('SELECT * FROM CATEGORY WHERE category_id = ?');
        $query->execute([$category_id]);
        $category = $query->fetch(PDO::FETCH_OBJ);
        return $category;
    }
    
   public function createCategory($category_name){
    
    $query = $this->db->prepare('INSERT INTO category (category) VALUES(?)');
    $query->execute([$category_name]);
    return $query;
   }

    
    public function updateCategory($category_id, $category_name){
        $query = $this->db->prepare('UPDATE category 
            SET category = ? WHERE category_id = ?');
        $query->execute([$category_name, $category_id]);
        return $query;
    }
    

    public function deleteCategory($category_id) {
        $checkQuery = $this->db->prepare('SELECT COUNT(*) FROM product WHERE category_id = ?');
        $checkQuery->execute([$category_id]);
        $productCount = $checkQuery->fetchColumn();
    
        if ($productCount > 0) {
            $deleteProductsQuery = $this->db->prepare('DELETE FROM product WHERE category_id = ?');
            $deleteProductsQuery->execute([$category_id]);
        }
    
        $deleteCategoryQuery = $this->db->prepare('DELETE FROM category WHERE category_id = ?');
        $deleteCategoryQuery->execute([$category_id]);
    
        return  $deleteCategoryQuery;
    }
}


?>