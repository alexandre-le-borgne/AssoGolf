<?php

namespace UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Created by PhpStorm.
 * User: GCC-MED
 * Date: 13/04/2016
 * Time: 16:29
 */
class UserExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $definition = new Definition('UserBundle\Twig\UserExtension');
        $definition->addTag('twig.extension');
        $container->setDefinition('user_extension', $definition); // le nom de l'extension renseigné dans "getName" de l'extension Twig
    }
}