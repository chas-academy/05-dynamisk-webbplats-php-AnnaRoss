<?php

    /* PHP Error Reporting ON */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    /* Include Fleshpress */
    require_once('./core/Fleshpress.php');

    /* Include custom models */
    require_once('./models/ArticleModel.php');
    require_once('./models/CategoryModel.php');
    require_once('./models/TagModel.php');
    require_once('./models/UserModel.php');

    // require_once('./models/ArticleCategoryModel.php');
    // require_once('./models/ArticleTagModel.php');
    // require_once('./models/ArticleUserModel.php');
    
    /* Instantiate Fleshpress */
    $app = new Fleshpress();

    /* Register Routes and Controllers */
    $app->get('/', function($req, $res)
    {
        $properties = [
            'title' => 'Starturu!',
            'content' => 'This is the start page'
        ];

        $res->render_template('start.html', $properties);
    });

    /* User log in */
    $app->post('/login', function($req, $res)
    {   
        $username = $req->body['username'];
        $userFound = UserModel::find(['username' => $username]);
        // om username inte hittas, rendera message till usern
        // hitta ett username med username
        // make use of fleshpress's session thingy - check if the user is of type 'admin' or 'regular'
        // last step: if login succeds, redirect to editing views!
        $res->redirect('/');
    });


    $app->get('/articles', function($req, $res)
    {
        $articles = ArticleModel::findAll();

        $res->render_template('articles.html', ['articles' => $articles]);
    });

    $app->post('/articles', function($req, $res)
    {
        $newArticle = new ArticleModel(
            $req->body['headline'], // In the request body ['html element's attributed name]
            $req->body['runningtext']
        );

        $returnedArticle = $newArticle->save();
        // 2. Save category

        // assigna choosen category to $articleReturn. plocka ut returned article id med nyckel-brackets.
        // plocka ut nyckel id för categorin
        //nya upp en instans av Article_Category, mata in id-värdena (vilket ska definieras i Article_CategoryModels consturcotr. och spara den.
        // 3. Save tags 
        // Just as above, but I will need a loop if there is multiple tags.
        $res->redirect('/articles');
    });


    $app->get('/categories', function($req, $res)
    {
        $categories = CategoryModel::findAll();

        $res->render_template('categories.html', ['categories' => $categories]);
    });

    $app->post('/categories', function ($req, $res)
    {
        $newCategory = new CategoryModel(
            $req->body['title'],
            $req->body['description']
        ); 

        $returnedCategory = $newCategory->save();
        
        $res->redirect('/categories');
    });

    /* Start the App */
    $app->start();
