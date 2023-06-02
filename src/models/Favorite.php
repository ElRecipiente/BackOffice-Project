<?php

namespace src\models;

use core\BaseModel;
use PDO;

class Favorite extends BaseModel
{
    public function __construct()
    {
        $this->table = 'favorite';
        $this->getConnection();
    }

    // vérifie si le favori existe
    public function checkFavorite($productid, $userid)
    {
        $sql = "SELECT * FROM  $this->table  WHERE id_product =  $productid AND id_user = $userid";
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // ajoute un favori
    public function addFavorite($productid, $userid)
    {
        $sql = "INSERT INTO $this->table (id_user, id_product) VALUES (:id_user, :id_product)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':id_user', $userid);
        $query->bindParam(':id_product', $productid);
        $query->execute();
    }

    // supprime un favori
    public function removeFavorite($productid, $userid)
    {
        $sql = "DELETE FROM $this->table WHERE id_product = :id_product AND id_user = :id_user";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':id_user', $userid);
        $query->bindParam(':id_product', $productid);
        $query->execute();
    }
}
