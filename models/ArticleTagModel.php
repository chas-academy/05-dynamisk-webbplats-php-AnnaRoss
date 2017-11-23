<?php

require_once('./core/Model.php');

class ArticleTagModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(
        int $articleId,
        int $tagId
    )

    {
        $this->schema = [
            'article_id' => $articleId,
            'tag_id' => $tagId
        ];
    }

    public static function register()
    {
        static::$tableName = 'articles_tags';
    }

}

ArticleTagModel::register();
