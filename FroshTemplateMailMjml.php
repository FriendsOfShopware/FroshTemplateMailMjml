<?php

namespace FroshTemplateMailMjml;

use FroshTemplateMailMjml\Components\MjmlCompiler;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;

/**
 * Class FroshTemplateMailMjml
 *
 * @author Soner Sayakci <shyim@posteo.de>
 */
class FroshTemplateMailMjml extends Plugin
{
    /**
     * @param InstallContext $context
     *
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function install(InstallContext $context)
    {
        if (MjmlCompiler::isMjmlInstalled() === null) {
            throw new \RuntimeException('MJML must be installed and accessable using $PATH');
        }
    }
}
