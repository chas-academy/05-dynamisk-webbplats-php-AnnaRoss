<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;

class ArticleCategoryModel extends AbstractModel
{   
    public function getRelatedCategory($articleId)
    {
        $query = 'SELECT category_id FROM article_category WHERE article_id = :article_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $articleId
        ];

        $statementHandle->execute($params);

        $result = $statementHandle->fetch(PDO::FETCH_ASSOC);

        return $result['category_id'];
    }

    public function getRelatedArticles($categoryId)
    {
        $query = 'SELECT article_id FROM article_category WHERE category_id = :category_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'category_id' => $categoryId
        ];

        $statementHandle->execute($params);

        return $statementHandle->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createRelation($articleId, $categoryId)
    {
        $query = 'INSERT INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $articleId,
            'category_id' => $categoryId
        ];
        
        $statementHandle->execute($params);
    }
    
    public function updateRelation($articleId, $categoryId)
    {
        $query = 'UPDATE article_category SET category_id = :category_id WHERE article_id = :article_id';

        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $articleId,
            'category_id' => $categoryId
        ];

        $statementHandle->execute($params);
    }

    public function deleteRelationToCategory($articleId)
    {
        $query = 'DELETE FROM article_category WHERE article_id = :article_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $articleId
        ];
        
        $statementHandle->execute($params);
    }

    public function deleteRelationToArticles($categoryId)
    {
        $query = 'DELETE FROM article_category WHERE category_id = :category_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'category_id' => $categoryId
        ];
        
        $statementHandle->execute($params);
    }
}
