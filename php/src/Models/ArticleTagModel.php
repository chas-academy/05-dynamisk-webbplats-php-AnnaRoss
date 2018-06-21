<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;

class ArticleTagModel extends AbstractModel
{
    public function createRelationship($articleId, $tagIds)
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

    public function deleteRelationship($id)
    {
        $query = 'DELETE FROM article_tag WHERE article_id = :article_id OR tag_id = :tag_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $id,
            'tag_id' => $id
        ];
        
        $statementHandle->execute($params);
    }

    public function getRelated($id)
    {
        $query = 'SELECT tag_id FROM article_tag WHERE article_id = :article_id';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'article_id' => $id
        ];

        $statementHandle->execute($params);

        return $statementHandle->fetchAll(PDO::FETCH_ASSOC);
    }

}
