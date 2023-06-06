<?php

namespace src\models;

use core\BaseModel;
use PDO;

class User extends BaseModel
{
    public function __construct()
    {
        $this->table = 'users';
        $this->getConnection();
    }

    public function updateUser($id)
    {
        $budget = $_POST['budget'];
        $sql = "UPDATE " . $this->table . " SET budget = :budget WHERE id = " . $id;
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':budget', $budget);
        $query->execute();
    }

    public function addNewUser()
    {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $budget = $_POST['budget'];
        $isAdmin = $_POST['isAdmin'];


        $sql = "INSERT INTO " . $this->table . " (username, password, budget, isAdmin) VALUES (:username, :password, :budget,:isAdmin)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':username', $username);
        $query->bindParam('password', $password);
        $query->bindParam(':budget', $budget);
        $query->bindParam(':isAdmin', $isAdmin);
        $query->execute();
    }

    public function connect()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT id, username FROM users WHERE username = :username AND 'password' = :password AND isAdmin = 1";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function consumeCredish($id, $price)
    {
        $sql = "UPDATE " . $this->table . " SET budget = budget-" . $price . " WHERE id = " . $id . " AND budget > 0";
        $query = $this->_connexion->prepare($sql);
        $query->execute();
    }

    public function auth($username, $password)
    {
        $sql = "SELECT id FROM $this->table WHERE username = :username AND password = :password";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
