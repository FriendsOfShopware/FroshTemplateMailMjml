<?php

namespace FroshTemplateMailMjml\Components;

use Symfony\Component\Process\ExecutableFinder;
use Zend_Cache_Core;
use Zend_Cache_Exception;

/**
 * Class MjmlCompiler
 *
 * @author Soner Sayakci <shyim@posteo.de>
 */
class MjmlCompiler implements MjmlCompilerInterface
{
    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var Zend_Cache_Core
     */
    private $cache;

    /**
     * MjmlCompiler constructor.
     *
     * @param string          $cacheDir
     * @param Zend_Cache_Core $cache
     *
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(string $cacheDir, Zend_Cache_Core $cache)
    {
        $this->cacheDir = $cacheDir;
        $this->cache = $cache;
    }

    /**
     * @param string $file
     *
     * @author Soner Sayakci <shyim@posteo.de>
     *
     * @throws CompileErrorException
     * @throws Zend_Cache_Exception
     *
     * @return string
     */
    public function compile(string $file): string
    {
        $cacheKey = 'mjml' . md5_file($file);

        if ($content = $this->cache->load($cacheKey)) {
            return $content;
        }

        $outputFile = $this->cacheDir . '/' . uniqid('mjml', true);

        exec(sprintf('%s -o %s %s', self::isMjmlInstalled(), $outputFile, $file), $result);

        if (isset($result[0]) && strpos($result[0], 'migrating') === false) {
            throw new CompileErrorException($result[0]);
        }

        $content = file_get_contents($outputFile);
        @unlink($outputFile);

        $this->cache->save($content, $cacheKey, ['Shopware_Plugin']);

        return $content;
    }

    /**
     * @return string
     *
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public static function isMjmlInstalled(): string
    {
        $finder = new ExecutableFinder();

        return $finder->find('mjml');
    }
}
