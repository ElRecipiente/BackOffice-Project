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

        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {
            $name = $_POST['name'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];

            $sql = "UPDATE " . $this->table . " SET name = :name, quantity = :quantity, price = :price WHERE id = " . $id;
            $query = $this->_connexion->prepare($sql);
            $query->bindParam(':name', $name);
            $query->bindParam(':quantity', $quantity);
            $query->bindParam(':price', $price);
            $query->execute();

            return true;
        } else {
            echo "C'est mort, remplis tous les champs wesh.";
            return false;
        }
    }
}
