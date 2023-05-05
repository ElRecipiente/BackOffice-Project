<?php

namespace src\models;

use core\BaseModel;

class User extends BaseModel
{
    public function __construct()
    {
        $this->table = 'users';
        $this->getConnection();
    }
}
