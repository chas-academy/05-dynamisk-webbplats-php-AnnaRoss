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

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAll();

        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryId = $articleCategoryModel->getRelatedCategory($id);
        $category = $categoryModel->get($articleCategoryId);

        $article->setCategory($category);

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
            'category' => $category,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function getAll()
    {   
        $articleModel = new ArticleModel();
        $articles = $articleModel->getAll();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAll();

        foreach ($articles as $article) {
            $articleCategoryModel = new ArticleCategoryModel();
            $articleCategoryId = $articleCategoryModel->getRelatedCategory($article->getId());
            $category = $categoryModel->get($articleCategoryId);
    
            $article->setCategory($category);
        }

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
        $articleCategoryModel->createRelation($newArticle->getId(), $categoryId);

        $this->setTagRelations($newArticle->getId(), $tagIds);
        
        return $this->getAll();
    }

    public function update($id)
    {   
        $params = $this->request->getParams();
        $headline = $params->get('headline');
        $content = $params->get('content');
        $categoryId = $params->get('categoryId');
        $tagIds = $params->get('tagIds');
        
        $articleCategoryModel = new ArticleCategoryModel();
        $this->removeCategoryRelation($id);
        $this->setCategoryRelation($id, $categoryId);

        $this->removeTagRelations($id);
        $this->setTagRelations($id, $tagIds);

        $articleModel = new ArticleModel();
        $articleModel->update($id, $headline, $content);

        return $this->get($id);
    }

    public function delete($id)
    {   
        $params = $this->request->getParams();
        var_dump($params);
        
        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->deleteRelation($id);

        $this->removeTagRelations($id);

        $articleModel = new ArticleModel();
        $articleModel->delete($id);

        return $this->getAll();
    }

    public function addCategoryToArticleInterface($articleId)
    {
        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryId = $articleCategoryModel->getRelatedCategory($articleId);

        $category = $categoryModel->get($articleCategoryId);
    
        $article->setCategory($category);
    }

    public function setCategoryRelation($articleId, $categoryId)
    {
        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->createRelation($articleId, $categoryId);
    }

    public function removeCategoryRelation($articleId)
    {
        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->deleteRelation($articleId);
    }

    public function setTagRelations($articleId, $tagIds)
    {
        $articleTagModel = new ArticleTagModel();
        $articleTagModel->createRelations($articleId, $tagIds);
    }

    public function removeTagRelations($articleId)
    {
        $articleTagModel = new ArticleTagModel();
        $articleTagModel->deleteRelations($articleId, $tagIds);
    } 
}
