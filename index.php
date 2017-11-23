<?php

    /* PHP Error Reporting ON */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    /* Include Fleshpress */
    require_once('./core/Fleshpress.php');

    /* Include custom models */
    require_once('./models/ArticleModel.php');

    /* Instantiate Fleshpress */
    $app = new Fleshpress();

    /* Register Routes and Controllers */
    $app->get('/', function($req, $res)
    {
        $properties = [
            'title' => 'Hey',
            'content' => 'This is the start page'
        ];

        $res->render_template('start.html', $properties);
    });


    $app->get('/articles', function($req, $res)
    {
        $articles = ArticleModel::findAll();
        
        $res->render_template('articles.html', ['articles' => $articles]);
    });

    /* Start the App */
    $app->start();
