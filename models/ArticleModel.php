<?php

require_once('./core/Model.php');

class ArticleModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(
        string $headline, 
        string $runningtext
    )
    {
        $this->schema = [
            'headline' => $headline,
            'runningtext' => $runningtext,
            'publishing_date' => date("Y-m-d H:i:s")
        ];
    }

    public static function register()
    {
        static::$tableName = 'articles';
    }

}

ArticleModel::register();
