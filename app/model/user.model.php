<?php
        require_once 'app/model/model.php';



class UserModel extends Model{
 

    public function getByUsername($user_name){
        $query = $this->db->prepare('SELECT * FROM users WHERE user_name = ?');
        $query->execute([$user_name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

}


?>