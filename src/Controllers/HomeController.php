<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Category;
use App\Models\Article;

class HomeController
{
    private Category $category;
    private Article $article;

    public function __construct()
    {
        $this->category = new Category();
        $this->article = new Article();
    }

    public function index(): void
    {
        $categories = $this->category->findWithArticles();

        $categoriesWithArticles = [];
        foreach ($categories as $cat) {
            $cat['articles'] = $this->article->getLatestByCategory($cat['id'], 3);
            $categoriesWithArticles[] = $cat;
        }

        View::render('pages/home.tpl', [
            'categories' => $categoriesWithArticles,
            'title' => 'Главная',
        ]);
    }
}

