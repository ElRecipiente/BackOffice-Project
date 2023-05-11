<?php

namespace src\models;

use core\BaseModel;
use PDO;

class UserHistory extends BaseModel
{
    public function __construct()
    {
        $this->table = 'user_history';
        $this->getConnection();
    }

    public function getAll()
    {

        $sql = "SELECT * FROM $this->table JOIN users ON $this->table.id_user = users.id";
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertHistory($admin, $id_user, $budget_change)
    {

        $sql = "INSERT INTO $this->table (admin, id_user, budget_change) VALUES (:admin, :id_user, :budget_change)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':admin', $admin);
        $query->bindParam(':id_user', $id_user);
        $query->bindParam(':budget_change', $budget_change);
        $query->execute();
    }
}
