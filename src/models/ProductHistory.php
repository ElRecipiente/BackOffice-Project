<?php

namespace src\models;

use core\BaseModel;
use PDO;

class ProductHistory extends BaseModel
{
    public function __construct()
    {
        $this->table = 'product_history';
        $this->getConnection();
    }

    public function getAll()
    {

        $sql = "SELECT * FROM $this->table JOIN users ON $this->table.id_admin = users.id JOIN products ON $this->table.id_product = products.id";
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertHistory($id_admin, $id_product, $quantity_change, $price_change)
    {

        $sql = "INSERT INTO $this->table (id_admin, id_product, quantity_change, price_change) VALUES (:id_admin, :id_product, :quantity_change, :price_change)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':id_admin', $id_admin);
        $query->bindParam(':id_product', $id_product);
        $query->bindParam(':quantity_change', $quantity_change);
        $query->bindParam(':price_change', $price_change);
        $query->execute();
    }
}
