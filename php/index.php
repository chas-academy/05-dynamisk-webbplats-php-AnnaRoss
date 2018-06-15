<?php

use App\Core\Connection;

function autoloader($classname)
{
    $lastSlash = strpos($classname, '\\') + 1;
    $classname = substr($classname, $lastSlash);
    $filePathWithoutExtension = str_replace('\\', '/', $classname);
    $filename = __DIR__ . '/src/' . $filePathWithoutExtension . '.php';
    require_once($filename);
}

spl_autoload_register('autoloader');

$db = Connection::getInstance()->dbHandler;

$query = <<<SQL
    INSERT INTO articles (headline, content)
    VALUES (:headline, :content)

SQL;

$statement = $db->prepare($query);
$params = [
    'headline' => 'Destiny Productions',
    'content' => 'Destiny Productions FTW - The future is not written yet'
];

$statement->execute($params);

$getArticles = $db->query('SELECT * from articles');
$results = $getArticles->fetchAll(PDO::FETCH_ASSOC);

?>


<html>
    <head>
        <title>Hello World</title>
    </head>

    <body>
        <?php
            echo "Hello, World!";
        ?>
    
    <pre>
    <?php var_dump($results) ?>
    </pre>
        <pre>
           <!--  <?php var_dump($_SERVER) ?> -->
        </pre>
    </body>
</html>