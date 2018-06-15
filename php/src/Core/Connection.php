<?php 

namespace App\Core;

use App\Utils\Singleton;
use \PDO;

    class Connection extends Singleton
    {
        public $dbHandler;
        private $data;

        public function __construct()
        {
            try {
                $config = include('config/app.php');
    
                /* An instance of the PHP Data Object class */
                /* enables us to access the specified database */
                $this->dbHandler = new PDO(
                    $config['db']['dsn'],
                    $config['db']['user'],
                    $config['db']['password']
                ); 
    
                $this->dbHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        }
        
    }
