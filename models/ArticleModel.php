<?php

class ArticleModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(string $headline, string $runningtext) 
    {
        $this->schema = [
            'headline' => $headline,
            'runningtext' => $runningtext
        ];
    }

    public static function register()
    {
        static::$tableName = 'articles';
    }
}

ArticleModel::register();
