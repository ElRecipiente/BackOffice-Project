<?php

namespace src\models;

use core\BaseModel;
use PDO;

class History extends BaseModel
{
    public function __construct()
    {
        $this->table = 'history';
        $this->getConnection();
    }

    public function getAll()
    {

        $sql = "SELECT * FROM $this->table JOIN users ON $this->table.id_user = users.id JOIN products ON $this->table.id_product = products.id";
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertHistory($id_user, $id_product, $quantity_change) {
    
        $sql = "INSERT INTO $this->table (id_user, id_product, quantity_change) VALUES (:id_user, :id_product, :quantity_change)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':id_user', $id_user);
        $query->bindParam(':id_product', $id_product);
        $query->bindParam(':quantity_change', $quantity_change);
        $query->execute();
    }
}