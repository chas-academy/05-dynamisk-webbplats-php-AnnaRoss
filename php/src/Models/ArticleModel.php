<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;
use App\Interfaces\ArticleInterface;

class ArticleModel extends AbstractModel
{
    const CLASSNAME = '\App\Interfaces\ArticleInterface';

    public function getAll(): array
    {
        $query = 'SELECT * FROM articles';
        $statementHandle = $this->db->prepare($query);
        $statementHandle->execute();

        return $statementHandle->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function create($headline, $content)
    {
        $query = 'INSERT INTO articles (headline, content, publication_date) VALUES (:headline, :content, :publication_date)';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
        'headline' => $headline,
        'content' => $content,
        'publication_date' => date("Y-m-d H:i:s")
        ];
        
        $statementHandle->execute($params);

        return $this->find($this->db->lastInsertId());
    }

    public function find($id)
    {
        $query = 'SELECT * FROM articles WHERE id = :id';
        $statementHandle = $this->db->prepare($query);
        $statementHandle->execute(['id' => $id]);

        return $statementHandle->fetchObject(self::CLASSNAME);
    }
}
