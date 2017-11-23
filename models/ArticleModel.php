<?php

require_once('./core/Model.php');

class ArticleModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(
        string $headline, 
        string $runningtext
        // tbd way to attach category
        // tbd way to attach tag/tags 
    )
    {
        $this->schema = [
            'headline' => $headline,
            'runningtext' => $runningtext,
        ];
    }

    public static function register()
    {
        static::$tableName = 'articles';
    }

}

ArticleModel::register();
