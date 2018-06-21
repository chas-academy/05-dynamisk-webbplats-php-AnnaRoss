<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;
use App\Interfaces\CategoryTagInterface;

class TagModel extends AbstractModel
{
    const CLASSNAME = '\App\Interfaces\CategoryTagInterface';

    public function get($id)
    {
        $query = 'SELECT * FROM tags WHERE id = :id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id
        ];
            
        $statementHandle->execute($params);

        return $statementHandle->fetchObject(self::CLASSNAME);
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM tags';

        $statementHandle = $this->db->prepare($query);

        $statementHandle->execute();

        return $statementHandle->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function create($title)
    {
        $query = 'INSERT INTO tags (title) VALUES (:title)';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'title' => $title
        ];
        
        $statementHandle->execute($params);

        return $this->get($this->db->lastInsertId());
    }

    public function update($id, $title)
    {   
        $query = 'UPDATE tags SET title = :title WHERE id = :id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id,
            'title' => $title
        ];
            
        $statementHandle->execute($params);
    }

    public function delete($id)
    {   
        $query = 'DELETE FROM tags WHERE id = :id';
                
        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id,
        ];

        $statementHandle->execute($params);
    }
}
