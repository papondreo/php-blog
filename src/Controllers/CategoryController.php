<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Category;
use App\Models\Article;

class CategoryController
{
    private Category $category;
    private Article $article;
    private int $perPage;

    public function __construct()
    {
        $this->category = new Category();
        $this->article = new Article();
        $config = require dirname(__DIR__) . '/Config/config.php';
        $this->perPage = $config['app']['per_page'];
    }

    public function show(string $slug): void
    {
        $category = $this->category->findBySlug($slug);

        if (!$category) {
            http_response_code(404);
            View::render('pages/404.tpl');
            return;
        }

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $sort = in_array($_GET['sort'] ?? '', ['date', 'views']) ? $_GET['sort'] : 'date';

        $articles = $this->article->getByCategoryPaginated(
            $category['id'],
            $page,
            $this->perPage,
            $sort
        );

        $totalArticles = $this->article->countByCategory($category['id']);
        $totalPages = (int) ceil($totalArticles / $this->perPage);

        View::render('pages/category.tpl', [
            'category' => $category,
            'articles' => $articles,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'title' => $category['name'],
        ]);
    }
}

