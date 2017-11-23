<?php

require_once('./core/Model.php');

class ArticleCategoryModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(
        int $articleId,
        int $categoryId
    )
    {
        $this->schema = [
            'article_id' => $articleId,
            'category_id' => $categoryId
        ];
    }

    public static function register()
    {
        static::$tableName = 'articles_categories';
    }

}

ArticleCategoryModel::register();