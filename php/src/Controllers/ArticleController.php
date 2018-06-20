<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\ArticleCategoryModel;

class ArticleController extends AbstractController
{
    public function get($id)
    {   
        $articleModel = new ArticleModel();
        $article = $articleModel->get($id);

        return $this->render('views/article.html', [
            'article' => $article 
        ]);
    }

    public function getAll()
    {   
        $articleModel = new ArticleModel();
        $articles = $articleModel->getAll();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAll();

        return $this->render('views/articles.html', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    public function create()
    {   
        $params = $this->request->getParams();
        $headline = $params->get('headline');
        $content = $params->get('content');
        $categoryId = $params->get('categoryId');

        $articleModel = new ArticleModel();
        $newArticle = $articleModel->create($headline, $content);

        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->createRelationship($newArticle->getId(), $categoryId);
        
        return $this->getAll();
    }

    public function update($id)
    {   
        $params = $this->request->getParams();
        $headline = $params->get('headline');
        $content = $params->get('content');

        $articleModel = new ArticleModel();
        $updatedArticle = $articleModel->update($id, $headline, $content);

        return $this->get($id);
    }

    public function delete($id)
    {   
        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->deleteRelationship($id);

        $articleModel = new ArticleModel();
        $articleModel->delete($id);

        return $this->getAll();
    }
}
