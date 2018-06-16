<?php

namespace App\Models;

use App\Models\AbstractModel;
use PDO;

class ArticleModel extends AbstractModel
{
    public function getAll(): array
    {
        $query = 'SELECT * FROM articles';
        $statementHandle = $this->db->prepare($query);
        $statementHandle->execute();

        return $statementHandle->fetchAll(PDO::FETCH_ASSOC);
    }
}
