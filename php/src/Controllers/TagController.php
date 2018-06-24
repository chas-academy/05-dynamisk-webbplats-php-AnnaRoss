<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\TagModel;
use App\Models\ArticleModel;
use App\Models\ArticleTagModel;

class TagController extends AbstractController
{
    public function get($id)
    {   
        $tagModel = new TagModel();
        $tag = $tagModel->get($id);

        $articleTagModel  = new ArticleTagModel();
        $articleIds = $articleTagModel->getRelatedArticles($id);

        $articleModel = new ArticleModel();
        $articles = [];

        foreach ($articleIds as $articleId) {
            // Get the complete article instead of just the ID
            $article = $articleModel->get($articleId['article_id']);

            // Get the all of the articles tagIds
            $articleTags = $articleTagModel->getRelatedTags($article->getId());

            // Loop over the tagIds in order to get the complete tag mapped to the CategoryTagInterface
            $tags = [];
            foreach ($articleTags as $articleTag) {
                $tags[] = $tagModel->get($articleTag['tag_id']);
            }

            // Add the tags to the article-object in order to make it easier to use in the view
            $article->setTags($tags);

            $articles[] = $article;
        }
        
        return $this->render('views/tag.html', [
            'tag' => $tag,
            'articles' => $articles,
        ]);
    }

    public function getAll()
    {   
        $tagModel = new TagModel();
        $tags = $tagModel->getAll();

        return $this->render('views/tags.html', [
            'tags' => $tags
        ]);
    }
    
    public function create()
    {  
        $title = $this->request->getParams()->get('title');

        $tagModel = new TagModel();
        $newtag = $tagModel->create($title);

        return $this->getAll();
    }

    public function update($id)
    {   
        $title = $this->request->getParams()->get('title');

        $tagModel = new TagModel();
        $updatedTag = $tagModel->update($id, $title);

        return $this->get($id);
    }

    public function delete($id)
    {   
        $articleTagModel = new ArticleTagModel();
        $articleTagModel->deleteArticleRelations($id);
        
        $tagModel = new TagModel();
        $tagModel->delete($id);

        return $this->getAll();
    }
}
