<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Article
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE slug = ?");
        $stmt->execute([$slug]);
        $article = $stmt->fetch();

        if ($article) {
            $article['categories'] = $this->getArticleCategories($article['id']);
        }

        return $article ?: null;
    }

    public function getLatestByCategory(int $categoryId, int $limit = 3): array
    {
        $sql = "SELECT a.* FROM articles a
                INNER JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = ?
                ORDER BY a.created_at DESC
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId, $limit]);
        return $stmt->fetchAll();
    }

    public function getByCategoryPaginated(
        int $categoryId,
        int $page = 1,
        int $perPage = 6,
        string $sort = 'date'
    ): array {
        $offset = ($page - 1) * $perPage;
        $orderBy = $sort === 'views' ? 'a.views DESC' : 'a.created_at DESC';

        $sql = "SELECT a.* FROM articles a
                INNER JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = ?
                ORDER BY {$orderBy}
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId, $perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $sql = "SELECT COUNT(DISTINCT a.id) FROM articles a
                INNER JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return (int) $stmt->fetchColumn();
    }

    public function getSimilar(int $articleId, array $categoryIds, int $limit = 3): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $sql = "SELECT DISTINCT a.* FROM articles a
                INNER JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id IN ({$placeholders}) AND a.id != ?
                ORDER BY a.created_at DESC
                LIMIT ?";

        $params = array_merge($categoryIds, [$articleId, $limit]);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE articles SET views = views + 1 WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO articles (title, slug, description, content, image) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['description'] ?? null,
            $data['content'],
            $data['image'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function attachCategories(int $articleId, array $categoryIds): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO article_category (article_id, category_id) VALUES (?, ?)"
        );
        foreach ($categoryIds as $categoryId) {
            $stmt->execute([$articleId, $categoryId]);
        }
    }

    private function getArticleCategories(int $articleId): array
    {
        $sql = "SELECT c.* FROM categories c
                INNER JOIN article_category ac ON c.id = ac.category_id
                WHERE ac.article_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }
}

