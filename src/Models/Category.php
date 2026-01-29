<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Category
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findWithArticles(): array
    {
        $sql = "SELECT c.* FROM categories c
                INNER JOIN article_category ac ON c.id = ac.category_id
                GROUP BY c.id
                ORDER BY c.name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)"
        );
        $stmt->execute([$data['name'], $data['slug'], $data['description'] ?? null]);
        return (int) $this->db->lastInsertId();
    }
}

