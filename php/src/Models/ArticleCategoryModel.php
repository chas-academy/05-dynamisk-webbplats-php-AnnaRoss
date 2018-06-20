<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;

class ArticleCategoryModel extends AbstractModel
{
    public function createRelationship($articleId, $categoryId)
    {
        $query = 'INSERT INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $articleId,
            'category_id' => $categoryId
        ];
        
        $statementHandle->execute($params);
    }

    public function deleteRelationship($id)
    {
        $query = 'DELETE FROM article_category WHERE article_id = :article_id OR category_id = :category_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $id,
            'category_id' => $id
        ];
        
        $statementHandle->execute($params);
    }

}
