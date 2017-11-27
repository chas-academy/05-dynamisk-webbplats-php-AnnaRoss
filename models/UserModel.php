<?php

require_once('./core/Model.php');

class UserModel extends Model 
{
    protected static $tableName;
    protected $schema;

    public function __construct(
        string $username,
        string $password,
        string $email
    )
    {
        $this->schema = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
            'email' => $email
        ];
    }

    public static function register()
    {
        static::$tableName = 'users';
    }
}

UserModel::register();
