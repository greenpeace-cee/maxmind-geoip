<?php

namespace Maxmind\Bundle\GeoipBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('maxmind_geoip');
    
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('maxmind_geoip');
        }

        $path = realpath(__DIR__.'/../../../../../data/GeoLiteCity.dat');

        $info = 'The file path to the .dat file (e.g. the GeoLiteCity.dat) to be used for ip-geo-locating.';

        if ($path === false) {
            $path = __DIR__.'/../../../../../data/GeoLiteCity.dat';
            $info .= "\nThe file is not yet present. Download it from http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz and unzip it.";
        }

        $rootNode
            ->children()
                ->scalarNode('data_file_path')->defaultValue($path)->info($info)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
