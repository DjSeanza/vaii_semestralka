<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Category;
use public\toast\Errors;
use public\toast\Successes;

class CategoryController extends AControllerBase
{

    public function index(): Response
    {
        return $this->redirect("?c=category&a=listCategories");
    }

    /**
     * @throws \Exception
     */
    public function listCategories(): Response {
        $errorId = $this->request()->getValue("e");

        if ($errorId) {
            return $this->html(viewName: "category");
        }

        $categories = Category::getAll();

        if ($categories) {
            return $this->html(["categories" => $categories], viewName: "category");
        }

        return $this->redirect("?c=category&a=listCategories&e=" . Errors::CATEGORY_NOT_FOUND->value);
    }

    /**
     * @throws \Exception
     */
    public function formCategory(): Response {
        $category_id = $this->request()->getValue("cid");
        if (isset($category_id) && $category_id) {
            $category = Category::getOne($category_id);
            return $this->html(["category" => $category], "form.category");
        }

        return $this->html(viewName: "form.category");
    }

    /**
     * @throws \Exception
     */
    public function storeCategory(): Response {
        $category_id = $this->request()->getValue("cid");
        $data = $this->app->getRequest()->getPost();
        $category = ( $category_id ? Category::getOne($category_id) : new Category());

        if (isset($data['categoryName'])) {
            $category->setCategoryName($data['categoryName']);
        } else {
            return $this->redirect('?c=category&a=listCategories&e=' . Errors::UNEXPECTED_ERROR->value);
        }

        $category->save();
        return $this->redirect('?c=category&a=listCategories&s=' . Successes::CATEGORY_ADDED->value);
    }

    /**
     * @throws \Exception
     */
    public function deleteCategory(): Response {
        $category_id = $this->request()->getValue("cid");

        if (!$category_id) {
            return $this->redirect('?c=category&a=listCategories&e=' . Errors::CATEGORY_NOT_FOUND->value);
        }

        $category = Category::getOne($category_id);

        if ($category) {
            $category->delete();
        } else {
            return $this->redirect('?c=category&a=listCategories&e=' . Errors::CATEGORY_NOT_FOUND->value);
        }

        return $this->redirect("?c=category&a=listCategories&s=" . Successes::CATEGORY_DELETED->value);
    }
}