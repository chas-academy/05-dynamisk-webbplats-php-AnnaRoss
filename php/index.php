<?php

require_once('./src/core/Connection.php');

$db = Connection::getInstance()->db_handler;

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
            echo "Hello, World!!!!";
        ?>
    
    <pre>
    <?php var_dump($results) ?>
    </pre>
        <pre>
           <!--  <?php var_dump($_SERVER) ?> -->
        </pre>
    </body>
</html>