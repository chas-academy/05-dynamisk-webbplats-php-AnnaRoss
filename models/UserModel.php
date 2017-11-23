<?php

require_once('./core/Model.php');

class UserModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(
        string $username,
        string $email,
        string $type
    )

    {
        $this->schema = [
            'username' => $username,
            'email' => $email,
            'type' => $type
        ];
    }

    public static function register()
    {
        static::$tableName = 'users';
    }

}

UserModel::register();
