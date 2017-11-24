<?php

    /* PHP Error Reporting ON */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    /* Include Fleshpress */
    require_once('./core/Fleshpress.php');

    /* Include Session */
    require_once('./middleware/Session.php');

    /* Include custom models */
    require_once('./models/ArticleModel.php');
    require_once('./models/CategoryModel.php');
    require_once('./models/TagModel.php');
    require_once('./models/UserModel.php');
    require_once('./models/ArticleCategoryModel.php');
    require_once('./models/ArticleTagModel.php');
    // require_once('./models/ArticleUserModel.php');
    
    /* Instantiate Fleshpress */
    $app = new Fleshpress();
    $app->use(new Session);

    /* Register Routes and Controllers */
    $app->get('/', function($req, $res)
    {
        $properties = [
            'sitetitle' => 'Blogeru <3',
            'content' => 'This is starturupageuru!'
        ];

        $res->render_template('start.html', $properties);
    });
    
    /***************** user ***********************/
    $app->post('/login', function($req, $res)
    {   
        $username = $req->body['username'];
        $userFound = UserModel::find(['username' => $username]);
        // om username inte hittas, rendera message till usern
        // hitta ett username med username
        // make use of fleshpress's session thingy - check if the user is of type 'admin' or 'regular'
        // last step: if login succeds, redirect to editing views!
        $req->session->user = $userThatWasLoggedIn;

        $res->redirect('/');
    });
    // if req->session->user - tillgänliga vid alla routes
    // if req->session->user - sätta till null vid inloggning. 

    $app->get('/edit', 'checkAccessRights', function($req, $res)
    {
        $res->redirect('/edit');
        
    });

    function checkAcessRights($req, $res) {
        $hasAccessRights = false;

        if (! $hasAccessRights) {
            $res->json(["message" => "You shall not pass"], 401); // status code 401 - request is unauthorized
        }
    }



    $app->get('/users', function($req, $res)
    {
        $users = UserModel::findAll();
        $properties = [
            'username' => $username,
        ];

        $res->render_template('users.html', ['users' => $users]);
    });


    $app->post('/users', function ($req, $res)
    {
        $newUser = new UserModel(
            $req->body['username'],
            $req->body['email'],
            $req->body['password']
        ); 

        $returnedUser = $newUser->save();
        
        $res->redirect('/users');
    });

    /***************** articles ***********************/
    $app->get('/articles', function($req, $res)
    {
        $articles = ArticleModel::findAll();
        $categories = CategoryModel::findAll();
        $tags = TagModel::findAll();

        $res->render_template('articles.html', [
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags
        ]);
    });

    $app->post('/articles', function($req, $res)
    {
        $newArticle = new ArticleModel(
            $req->body['headline'], // In the request body ['html element's attributed name]
            $req->body['runningtext']
        );

        $returnedArticle = $newArticle->save();

        $newArticleCategory = new ArticleCategoryModel(
            $returnedArticle['id'], 
            $req->body['category']
        ); 

        $newArticleCategory->save(); 
        // assigna choosen category to $articleReturn. plocka ut returned article id med nyckel-brackets.
        // plocka ut nyckel id för categorin
        //nya upp en instans av Article_Category, mata in id-värdena (vilket ska definieras i Article_CategoryModels consturcotr. och spara den.
        // 3. Save tags Just as above, but I will need a loop if there is multiple tags
        $newArticleTag = new ArticleTagModel(
            $returnedArticle['id'],
            $req->body['tag']
        );

        $newArticleTag->save();

        $res->redirect('/articles');
    });

    
    /**************** categories *********************/

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
        
        $res->redirect('/articles');
    });


    /***************** tags ***********************/

    $app->get('/tags', function($req, $res)
    {
        $tags = TagModel::findAll();

        $res->render_template('tags.html', ['tags' => $tags]);
    });

    $app->post('/tags', function ($req, $res)
    {
        $newTag = new TagModel(
            $req->body['title']
        ); 

        $returnedTag = $newTag->save();
        
        $res->redirect('/articles');
    });

    /* Start the App */
    $app->start();
