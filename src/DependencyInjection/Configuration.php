<?php

declare(strict_types=1);

namespace Darake\SculpinRelatedPostsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sculpin_related_posts_by_taxonomy');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('max_per_page')->end()
            ->scalarNode('taxonomy_type')->end()
            ->end();

        return $treeBuilder;
    }
}
