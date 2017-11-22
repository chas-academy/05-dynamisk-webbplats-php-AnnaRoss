<?php

    /* PHP Error Reporting ON */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    /* Include Fleshpress */
    require_once('./core/Fleshpress.php');

    /* Instantiate Fleshpress */
    $app = new Fleshpress();

    /* Register Routes and Controllers */
    $app->get('/', function($req, $res) {

        $properties = [
            'title' => 'Hello World!',
            'content' => 'This is the start page'
        ];

        $res->render_template('start.html', $properties);
    });

    /* Start the App */
    $app->start();

?>
