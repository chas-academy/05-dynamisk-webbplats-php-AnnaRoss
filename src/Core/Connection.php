
<?php

namespace Blog\Core;

use \PDO;
use Blog\Core\Config;
use Blog\Utils\Singleton;

class Connection extends Singleton
{
    public $dbhandler;
    protected function __construct()
    {
        try {
            $config = Config::getInstance()->get('db');
            $this->$dbhandler = new PDO(
            $config['dsn'],
            $config['user'],
            $config['password']
            );
            $this->dbhandler->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }
}

/* 	Clearly I have borrowed Axels Connection class. 
		class Connection creates a new PHP Data Object using the values in app.json. */