<?php

namespace FroshTemplateMailMjml\Components;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Zend_Cache_Core;

/**
 * Class MjmlCompilerFactory
 * @author Soner Sayakci <shyim@posteo.de>
 */
class MjmlCompilerFactory
{
    /**
     * @param Zend_Cache_Core $cache
     * @param string $cacheDir
     * @param ContainerInterface $container
     * @return MjmlCompilerInterface
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public static function factory(Zend_Cache_Core $cache, string $cacheDir, ContainerInterface $container)
    {
        if ($container->hasParameter('shopware.mjml_api')) {
            return new WebMjmlCompiler($cache, $container->getParameter('shopware.mjml_api'));
        }

        return new MjmlCompiler($cacheDir, $cache);
    }
}