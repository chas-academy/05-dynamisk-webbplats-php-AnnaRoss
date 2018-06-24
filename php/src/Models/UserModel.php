<?php

namespace App\Models;

use PDO;
use App\Models\AbstractModel;

class UserModel extends AbstractModel
{
    const CLASSNAME = '\App\Interfaces\UserInterface';

    public function getByEmail($email)
    {
        $query = 'SELECT * FROM users WHERE email = :email';

        $statementHandle = $this->db->prepare($query);
        
        $params = [
            'email' => $email
        ];

        $statementHandle->execute($params);

        return $statementHandle->fetchObject(self::CLASSNAME);
    }
    
    public function create($alias, $email, $password)
    {
        $query = 'INSERT INTO users (alias, email, password) VALUES (:alias, :email, :password)';
        
        $statementHandle = $this->db->prepare($query);

        $params = [
            'alias' => $alias, 
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12])
        ];
        
        $statementHandle->execute($params);

        return $this->get($this->db->lastInsertId());
    }
}
