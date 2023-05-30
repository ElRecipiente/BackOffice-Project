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
}
