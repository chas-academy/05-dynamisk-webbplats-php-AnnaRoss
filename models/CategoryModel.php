<?php 

    require_once('./core/Model.php');

    class Example extends Model
    {

        protected static $tableName;
        protected $schema;

        public function __construct(string $name)
        {
            $this->schema = [
                'name' => $name
            ];
        }

        public static function register()
        {
            static::$tableName = 'example_table';
        }

    }

    Example::register();

?>