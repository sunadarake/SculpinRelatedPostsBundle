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
use Darake\Sculpin\Bundle\RelatedPostsByTaxonomy\SculpinRelatedPostsByTaxonomyBundle;

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
    {% for relate in page.related %}
    <li><a href="{{ site.url }}/{{ relate.data.get('url') }}">{{ relate.title }}</a></li>
    {% endfor %}
</ul>
{% endif %}
```