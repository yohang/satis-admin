<?php

namespace SatisAdmin\MinkExtension;

use Behat\Behat\Extension\ExtensionInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class Extension implements ExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setDefinition('satis_admin.app', new Definition('SatisAdmin\Application', ['test']));
        $container->setDefinition(
            'browserkit.client',
            new Definition('Symfony\Component\HttpKernel\Client', [new Reference('satis_admin.app')])
        );
        $container->setDefinition(
            'behat.mink.driver.browserkit',
            new Definition('Behat\Mink\Driver\BrowserKitDriver', [new Reference('browserkit.client')])
        );

        $definition = new Definition('Behat\Mink\Session', [new Reference('behat.mink.driver.browserkit')]);
        $definition->addTag('behat.mink.session', ['alias' => 'silex']);
        $container->setDefinition('behat.mink.session.silex', $definition);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(ArrayNodeDefinition $builder)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getCompilerPasses()
    {
        return [];
    }
}
