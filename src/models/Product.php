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
}