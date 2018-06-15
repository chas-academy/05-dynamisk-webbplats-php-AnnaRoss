<?php 

require_once('./src/utils/Singleton.php');

    class Connection extends Singleton
    {
        public $db_handler;
        private $data;

        public function __construct()
        {
            try {
                $config = include('config/app.php');
    
                /* An instance of the PHP Data Object class */
                /* enables us to access the specified database */
                $this->db_handler = new PDO(
                    $config['db']['dsn'],
                    $config['db']['user'],
                    $config['db']['password']
                ); 
    
                $this->db_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        }
        
    }
