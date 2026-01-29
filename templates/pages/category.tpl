{extends file="layouts/main.tpl"}

{block name="content"}
    <section class="category-page">
        <div class="page-header">
            <h1>{$category.name}</h1>
            {if $category.description}
                <p class="description">{$category.description}</p>
            {/if}
        </div>

        <div class="sort-controls">
            <span>Сортировка:</span>
            <a href="?sort=date{if $currentPage > 1}&page={$currentPage}{/if}" 
               class="btn btn-sm {if $sort == 'date'}btn-active{/if}">По дате</a>
            <a href="?sort=views{if $currentPage > 1}&page={$currentPage}{/if}" 
               class="btn btn-sm {if $sort == 'views'}btn-active{/if}">По просмотрам</a>
        </div>

        <div class="articles-grid">
            {foreach $articles as $article}
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
            {foreachelse}
                <p class="empty-message">В этой категории пока нет статей.</p>
            {/foreach}
        </div>

        {if $totalPages > 1}
            <nav class="pagination">
                {if $currentPage > 1}
                    <a href="?page={$currentPage - 1}&sort={$sort}" class="btn">&laquo; Назад</a>
                {/if}

                {for $i=1 to $totalPages}
                    <a href="?page={$i}&sort={$sort}" 
                       class="btn {if $i == $currentPage}btn-active{/if}">{$i}</a>
                {/for}

                {if $currentPage < $totalPages}
                    <a href="?page={$currentPage + 1}&sort={$sort}" class="btn">Вперёд &raquo;</a>
                {/if}
            </nav>
        {/if}
    </section>
{/block}

