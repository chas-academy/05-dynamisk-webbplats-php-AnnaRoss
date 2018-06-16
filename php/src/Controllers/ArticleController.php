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
        
        return var_dump($articles);
    }
}
