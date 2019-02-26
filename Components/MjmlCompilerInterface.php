<?php


namespace FroshTemplateMailMjml\Components;

use Zend_Cache_Core;

/**
 * Interface MjmlCompilerInterface
 * @author Soner Sayakci <shyim@posteo.de>
 */
interface MjmlCompilerInterface
{
    /**
     * @param string $file
     * @return string
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function compile($file);
}