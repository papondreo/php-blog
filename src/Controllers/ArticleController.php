<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Article;

class ArticleController
{
    private Article $article;

    public function __construct()
    {
        $this->article = new Article();
    }

    public function show(string $slug): void
    {
        $article = $this->article->findBySlug($slug);

        if (!$article) {
            http_response_code(404);
            View::render('pages/404.tpl');
            return;
        }

        $this->article->incrementViews($article['id']);
        $article['views']++;

        $categoryIds = array_column($article['categories'], 'id');
        $similar = $this->article->getSimilar($article['id'], $categoryIds, 3);

        View::render('pages/article.tpl', [
            'article' => $article,
            'similar' => $similar,
            'title' => $article['title'],
        ]);
    }
}

