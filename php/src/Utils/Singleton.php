<?php 

namespace App\Utils;

    abstract class Singleton 
    {
        private static $instances = [];

        protected function __construct() 
        {}

        public static function getInstance()
        {   /* The value of $class  is set to the name of the class instance that calls the getInstance method */
            $class = get_called_class();

            /* If that name doesn't exist in the instance array, */
            if (! isset(self::$instances[$class]))
            { /* then it will create an instance - with the $class as key, and update the instance array */
               self::$instances[$class] = new static();
            }
            /* Finally, the one and only class instance gets returned */
            return self::$instances[$class];
            
        }
    }

