<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;
use App\Interfaces\CategoryTagInterface;

class CategoryModel extends AbstractModel
{
    const CLASSNAME = '\App\Interfaces\CategoryTagInterface';

    public function get($id)
    {
        $query = 'SELECT * FROM categories WHERE id = :id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id
        ];
            
        $statementHandle->execute($params);

        return $statementHandle->fetchObject(self::CLASSNAME);
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM categories';

        $statementHandle = $this->db->prepare($query);

        $statementHandle->execute();

        return $statementHandle->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function create($title)
    {
        $query = 'INSERT INTO categories (title) VALUES (:title)';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'title' => $title
        ];
        
        $statementHandle->execute($params);

        return $this->get($this->db->lastInsertId());
    }

    public function update($id, $title)
    {   
        $query = 'UPDATE categories SET title = :title WHERE id = :id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id,
            'title' => $title
        ];
            
        $statementHandle->execute($params);
    }

    public function delete($id)
    {   
        $query = 'DELETE FROM categories WHERE id = :id';
                
        $statementHandle = $this->db->prepare($query);

        $params = [
            'id' => $id,
        ];

        $statementHandle->execute($params);
    }
}
