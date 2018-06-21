<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\CategoryModel;
use App\Models\ArticleCategoryModel;

class CategoryController extends AbstractController
{
    public function get($id)
    {   
        $categoryModel = new CategoryModel();
        $category = $categoryModel->get($id);

        return $this->render('views/category.html', [
            'category' => $category
        ]);
    }

    public function getAll()
    {   
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAll();

        return $this->render('views/categories.html', [
            'categories' => $categories
        ]);
    }
    
    public function create()
    {  
        $title = $this->request->getParams()->get('title');

        $categoryModel = new CategoryModel();
        $newCategory = $categoryModel->create($title);

        return $this->getAll();
    }

    public function update($id)
    {   
        $title = $this->request->getParams()->get('title');

        $categoryModel = new CategoryModel();
        $updatedCategory = $categoryModel->update($id, $title);

        return $this->get($id);
    }

    public function delete($id)
    {   
        $articleCategoryModel = new ArticleCategoryModel();
        $articleCategoryModel->deleteRelation($id);

        $categoryModel = new CategoryModel();
        $categoryModel->delete($id);

        return $this->getAll();
    }
}
