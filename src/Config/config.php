<?php

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'mysql',
        'database' => getenv('DB_NAME') ?: 'blog',
        'username' => getenv('DB_USER') ?: 'blog_user',
        'password' => getenv('DB_PASSWORD') ?: 'blog_password',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'base_url' => getenv('APP_URL') ?: 'http://localhost:8080',
        'per_page' => 6,
    ],
    'paths' => [
        'templates' => dirname(__DIR__, 2) . '/templates',
        'templates_c' => dirname(__DIR__, 2) . '/templates_c',
        'cache' => dirname(__DIR__, 2) . '/cache',
        'uploads' => dirname(__DIR__, 2) . '/public/uploads',
    ],
];

