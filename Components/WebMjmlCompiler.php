<?php

namespace FroshTemplateMailMjml\Components;

use Zend_Cache_Core;

/**
 * Class WebMjmlCompiler
 * @author Soner Sayakci <shyim@posteo.de>
 */
class WebMjmlCompiler implements MjmlCompilerInterface
{
    /**
     * @var Zend_Cache_Core
     */
    private $cache;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * MjmlCompiler constructor.
     *
     * @param Zend_Cache_Core $cache
     *
     * @param string $apiUrl
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(Zend_Cache_Core $cache, string $apiUrl)
    {
        $this->cache = $cache;
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param string $file
     * @return string
     * @throws CompileErrorException
     * @throws \Zend_Cache_Exception
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function compile(string $file): string
    {
        $cacheKey = 'mjml' . md5($file);

        if ($content = $this->cache->load($cacheKey)) {
            return $content;
        }

        $response = $this->requestToApi(file_get_contents($file));

        if (!empty($response['errors'])) {
            foreach ($response['errors'] as $item) {
                throw new CompileErrorException($item['message']);
            }
        }

        $this->cache->save($response['html'], $cacheKey, ['Shopware_Plugin']);

        return $content;
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     * @param string $content
     * @return array
     */
    private function requestToApi(string $content) : array
    {
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['mjml' => $content]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}