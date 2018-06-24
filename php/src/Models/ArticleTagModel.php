<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;

class ArticleTagModel extends AbstractModel
{
    public function getRelatedTags($articleId)
    {
        $query = 'SELECT tag_id FROM article_tag WHERE article_id = :article_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $articleId
        ];

        $statementHandle->execute($params);

        return $statementHandle->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRelatedArticles($tagId)
    {
        $query = 'SELECT article_id FROM article_tag WHERE tag_id = :tag_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'tag_id' => $tagId
        ];

        $statementHandle->execute($params);

        return $statementHandle->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createRelations($articleId, $tagIds)
    {
        foreach ($tagIds as $tagId) {
            $query = 'INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)';
        
            $statementHandle = $this->db->prepare($query);

            $params = [
                'article_id' => $articleId,
                'tag_id' => $tagId
            ];
            
            $statementHandle->execute($params); 
        }
    }

    public function deleteRelations($articleId)
    {
        $query = 'DELETE FROM article_tag WHERE article_id = :article_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $articleId,
        ];
        
        $statementHandle->execute($params);
    }
    
    public function deleteArticleRelations($tagId)
    {
        $query = 'DELETE FROM article_tag WHERE tag_id = :tag_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'tag_id' => $tagId,
        ];
        
        $statementHandle->execute($params);
    }
}
