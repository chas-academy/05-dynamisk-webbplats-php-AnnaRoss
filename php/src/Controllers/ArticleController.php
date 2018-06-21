<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\ArticleCategoryModel;
use App\Models\ArticleTagModel;

class ArticleController extends AbstractController
{
    public function get($id)
    {   
        $articleModel = new ArticleModel();
        $article = $articleModel->get($id);
        
        $tagModel = new TagModel();
        $allTags = $tagModel->getAll();

        $articleTagModel = new ArticleTagModel();
        $articleTagIds = $articleTagModel->getRelated($id);

        $tags = [];

        foreach ($allTags as $tag) {

            $tagToPush = [
                'id' => $tag->getId(),
                'title' => $tag->getTitle(),
                'selected' => false
            ];

            foreach ($articleTagIds as $articleTagId) {
                if ($tag->getId() == $articleTagId['tag_id']) {
                    $tagToPush['selected'] = true;
                }
            }

            $tags[] = $tagToPush;
        }

        return $this->render('views/article.html', [
            'article' => $article,
            'tags' => $tags
        ]);
    }

    public function getAll()
    {   
        $articleModel = new ArticleModel();
        $articles = $articleModel->getAll();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAll();
        
        $tagModel = new TagModel();
        $tags = $tagModel->getAll();

        return $this->render('views/articles.html', [
            'articles' => $articles,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function create()
    {   
        $params = $this->request->getParams();
        $headline = $params->get('headline');
        $content = $params->get('content');
        $categoryId = $params->get('categoryId');
        $tagIds = $params->get('tagIds');

        $articleModel = new ArticleModel();
        $newArticle = $articleModel->create($headline, $content);

        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->createRelationship($newArticle->getId(), $categoryId);

        $articleTagModel = new ArticleTagModel();
        $articleTagModel->createRelationship($newArticle->getId(), $tagIds);
        
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

        $articleTagModel = new ArticleTagModel();
        $articleTagModel->deleteRelationship($id);

        $articleModel = new ArticleModel();
        $articleModel->delete($id);

        return $this->getAll();
    }
}
