<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;
use App\Interfaces\ArticleInterface;

class ArticleModel extends AbstractModel
{
    const CLASSNAME = '\App\Interfaces\ArticleInterface';

    public function get($id)
    {
        $query = 'SELECT * FROM articles WHERE id = :id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id,
        ];

        $statementHandle->execute($params);
        
        return $statementHandle->fetchObject(self::CLASSNAME);
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM articles';
        $statementHandle = $this->db->prepare($query);

        $statementHandle->execute();

        return $statementHandle->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function create($headline, $content, $userId)
    {
        $query = 'INSERT INTO articles (headline, content, publication_date, user_id) VALUES (:headline, :content, :publication_date, :user_id)';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'headline' => $headline,
            'content' => $content,
            'publication_date' => date("Y-m-d H:i:s"),
            'user_id' => $userId
        ];
        
        $statementHandle->execute($params);

        return $this->get($this->db->lastInsertId());
    }

    public function update($id, $headline, $content)
    {   
        $query = 'UPDATE articles SET headline = :headline, content = :content WHERE id = :id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id,
            'headline' => $headline,
            'content' => $content
        ];

        $statementHandle->execute($params);
    }

    public function delete($id)
    {   
        $query = 'DELETE FROM articles WHERE id = :id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id,
        ];

        $statementHandle->execute($params);
    }
}
