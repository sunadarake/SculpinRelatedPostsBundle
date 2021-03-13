<?php

namespace Darake\SculpinRelatedPostsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SculpinRelatedPostsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $maxPerPage = array_key_exists('max_per_page', $config) ? $config['max_per_page'] : 5;
        $taxonomyType = array_key_exists('taxonomy_type', $config)  ? $config['taxonomy_type'] : "tags";

        $container->setParameter('sculpin_related_posts.max_per_page', $maxPerPage);
        $container->setParameter('sculpin_related_posts.taxonomy_type', $taxonomyType);
    }
}
