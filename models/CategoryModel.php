<?php 

    require_once('./core/Model.php');

    class CategoryModel extends Model
    {

        protected static $tableName;
        protected $schema;

        public function __construct(string $title, string $description)
        {
            $this->schema = [
                'title' => $title,
                'description' => $description
            ];
        }

        public static function register()
        {
            static::$tableName = 'categories';
        }

    }

    CategoryModel::register();
