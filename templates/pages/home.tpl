{extends file="layouts/main.tpl"}

{block name="content"}
    <section class="hero">
        <h1>Добро пожаловать в блог</h1>
        <p>Последние статьи по категориям</p>
    </section>

    {foreach $categories as $category}
        <section class="category-section">
            <div class="category-header">
                <h2>{$category.name}</h2>
                <a href="{$base_url}/category/{$category.slug}" class="btn btn-outline">Все статьи</a>
            </div>

            {if $category.description}
                <p class="category-description">{$category.description}</p>
            {/if}

            <div class="articles-grid">
                {foreach $category.articles as $article}
                    <article class="article-card">
                        {if $article.image}
                            <div class="article-image">
                                <img src="{$base_url}/uploads/{$article.image}" alt="{$article.title}">
                            </div>
                        {/if}
                        <div class="article-content">
                            <h3><a href="{$base_url}/article/{$article.slug}">{$article.title}</a></h3>
                            {if $article.description}
                                <p>{$article.description|truncate:120}</p>
                            {/if}
                            <div class="article-meta">
                                <span class="views">{$article.views} просмотров</span>
                                <span class="date">{$article.created_at|date_format:"%d.%m.%Y"}</span>
                            </div>
                        </div>
                    </article>
                {/foreach}
            </div>
        </section>
    {foreachelse}
        <p class="empty-message">Статьи пока не добавлены.</p>
    {/foreach}
{/block}

