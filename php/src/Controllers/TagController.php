<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\TagModel;
use App\Models\ArticleTagModel;

class TagController extends AbstractController
{
    public function get($id)
    {   
        $tagModel = new TagModel();
        $tag = $tagModel->get($id);

        return $this->render('views/tag.html', [
            'tag' => $tag
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
