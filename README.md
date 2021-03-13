# Sculpin Related Posts By Taxonomy Bundle

3rd party Sculpin Bunlde that creates related posts in sculpin blog.

## Setup

The recommended way to install this bundle is throught Composer.

```
composer require sunadarake/sculpin-related-posts-bundle
```

Add this bundle in your `app/SculpinKernel.php` file.

```php
<?php

use Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel;
use Darake\SculpinRelatedPostsBundle\SculpinRelatedPostsBundle;

class SculpinKernel extends AbstractKernel
{
    protected function getAdditionalSculpinBundles(): array
    {
        return [
            SculpinRelatedPostsByTaxonomyBundle::class,
        ];
    }
}

```

## How to use

If you write the following in `_posts/example.md` file,

~~~
```
title: "exampleTitile"
```
exampleText
~~~ 
you write the following in `_views/post.html` file.

```
{% if page.related %}
<ul>
    {% for related in page.related %}
    <li><a href="{{ site.url }}{{ related.data.get('url') }}">{{ related.title }}</a></li>
    {% endfor %}
</ul>
{% endif %}
```
The above code will be output as follows

```html
<ul>
    <li><a href="http://localhost:8000/php-array.html">The 10 most useful PHP array functions</a></li>
    <li><a href="http://localhost:8000/php-libraries.html">How to use PHP libraries by composer</a></li>
    <li><a href="http://localhost:8000/zend-engine.html">How Zend Engine works</a></li>
    <li><a href="http://localhost:8000/php-history.html">PHP history from 2000 to 2021</a></li>
    <li><a href="http://localhost:8000/php-debugging.html">Tutorial: Debuggin in PHP</a></li>
</ul>
```

## Config max_per_page

If you want to change the number of related posts, config `max_per_page` in `app/config/sculpin_kernel.yml`. (The default max_per_page is 5)

```
sculpin_content_types:
    posts:
        permalink: pretty
sculpin_related_posts:
    max_per_page: 3
```