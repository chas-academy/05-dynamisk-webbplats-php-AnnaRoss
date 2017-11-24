<?php

require_once('./core/Model.php');

class ArticleUserModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(
        int $articleId,
        int $userId
    )
    {
        $this->schema = [
            'article_id' => $articleId,
            'user_id' => $userId
        ];
    }

    public static function register()
    {
        static::$tableName = 'articles_users';
    }

}

ArticleUsersModel::register();
