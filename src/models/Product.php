<?php

namespace src\models;

use core\BaseModel;

class Product extends BaseModel
{
    public function __construct()
    {
        $this->table = 'products';
        $this->getConnection();
    }

    public function updateProduct($id)
    {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        $sql = "UPDATE " . $this->table . " SET name = :name, quantity = :quantity, price = :price WHERE id = " . $id;
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':name', $name);
        $query->bindParam(':quantity', $quantity);
        $query->bindParam(':price', $price);
        $query->execute();
    }

    public function addNewProduct()
    {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        $sql = "INSERT INTO " . $this->table . " (name, quantity, price) VALUES (:name, :quantity,:price)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':name', $name);
        $query->bindParam(':quantity', $quantity);
        $query->bindParam(':price', $price);
        $query->execute();
    }

    public function deleteThisProduct($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = " . $id;
        $query = $this->_connexion->prepare($sql);
        $query->execute();
    }
}
