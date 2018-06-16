<?php

namespace App\Models;

use App\Core\Connection;

abstract class AbstractModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Connection::getInstance()->dbHandle;
    }
}
