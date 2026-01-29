<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:'Блог'} | PHP Blog</title>
    <link rel="stylesheet" href="{$base_url}/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="{$base_url}/" class="logo">PHP Blog</a>
            <nav class="nav">
                <a href="{$base_url}/">Главная</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            {block name="content"}{/block}
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {$smarty.now|date_format:"%Y"} PHP Blog. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>

