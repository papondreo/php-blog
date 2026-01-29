{extends file="layouts/main.tpl"}

{block name="content"}
    <article class="article-page">
        <header class="article-header">
            <h1>{$article.title}</h1>
            <div class="article-meta">
                <span class="views">{$article.views} просмотров</span>
                <span class="date">{$article.created_at|date_format:"%d.%m.%Y"}</span>
            </div>
            <div class="article-categories">
                {foreach $article.categories as $cat}
                    <a href="{$base_url}/category/{$cat.slug}" class="tag">{$cat.name}</a>
                {/foreach}
            </div>
        </header>

        {if $article.image}
            <div class="article-featured-image">
                <img src="{$base_url}/uploads/{$article.image}" alt="{$article.title}">
            </div>
        {/if}

        {if $article.description}
            <div class="article-description">
                <p>{$article.description}</p>
            </div>
        {/if}

        <div class="article-body">
            {$article.content|nl2br}
        </div>
    </article>

    {if $similar}
        <section class="similar-articles">
            <h2>Похожие статьи</h2>
            <div class="articles-grid">
                {foreach $similar as $item}
                    <article class="article-card">
                        {if $item.image}
                            <div class="article-image">
                                <img src="{$base_url}/uploads/{$item.image}" alt="{$item.title}">
                            </div>
                        {/if}
                        <div class="article-content">
                            <h3><a href="{$base_url}/article/{$item.slug}">{$item.title}</a></h3>
                            {if $item.description}
                                <p>{$item.description|truncate:100}</p>
                            {/if}
                            <div class="article-meta">
                                <span class="views">{$item.views} просмотров</span>
                            </div>
                        </div>
                    </article>
                {/foreach}
            </div>
        </section>
    {/if}
{/block}

