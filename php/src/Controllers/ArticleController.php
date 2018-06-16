<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\ArticleModel;

class ArticleController extends AbstractController
{
    public function getAll()
    {   
        $articleModel = new ArticleModel();
        $articles = $articleModel->getAll();

        return $this->render('views/articles.html', [
            'articles' => $articles 
        ]);
    }

    public function create()
    {   
        $params = $this->request->getParams();
        $headline = $params->get('headline');
        $content = $params->get('content');

        $articleModel = new ArticleModel();
        $newArticle = $articleModel->create($headline, $content);

        return $this->getAll();
    }
}
