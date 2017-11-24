<?php 

    require_once('./core/Model.php');

    class TagModel extends Model
    {

        protected static $tableName;
        protected $schema;

        public function __construct(
            string $title
            )
        {
            $this->schema = [
                'title' => $title
            ];
        }

        public static function register()
        {
            static::$tableName = 'tags';
        }

    }

    TagModel::register();
