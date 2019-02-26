<?php

namespace FroshTemplateMailMjml\Components;

use Zend_Cache_Core;

/**
 * Class WebMjmlCompiler
 * @author Soner Sayakci <shyim@posteo.de>
 */
class WebMjmlCompiler implements MjmlCompilerInterface
{
    const MJML_INCLUDE = '/<mj-include.*?path="(.\/\w+)".*?\/>/m';

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
    public function compile($file)
    {
        $mjmlContent = file_get_contents($file);

        $cacheKey = 'mjml' . md5($mjmlContent);

        if ($content = $this->cache->load($cacheKey)) {
            return $content;
        }
        
        $mjmlContent = $this->parseIncludes($mjmlContent, dirname($file));

        $response = $this->requestToApi($mjmlContent);

        if (!empty($response['errors'])) {
            foreach ($response['errors'] as $item) {
                throw new CompileErrorException($item['message']);
            }
        }

        $this->cache->save($response['html'], $cacheKey, ['Shopware_Plugin']);

        return $response['html'];
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     * @param string $content
     * @return array
     */
    private function requestToApi($content)
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

    /**
     * @param string $string
     * @param string $folder
     * @return mixed|string
     * @throws CompileErrorException
     */
    private function parseIncludes($string, $folder)
    {
        preg_match_all(self::MJML_INCLUDE, $string, $matches);

        if (!empty($matches)) {
            foreach ($matches[0] as $key => $match) {
                if (strpos($matches[1][$key], 'mjml') === false) {
                    $matches[1][$key] .= '.mjml';
                }

                $fileName = $folder . '/' . $matches[1][$key];

                if (!file_exists($fileName)) {
                    throw new CompileErrorException(sprintf('File with name "%s", could not be found in path "%s"', $matches[1][$key], $fileName));
                }

                $string = str_replace($match, file_get_contents($fileName), $string);
            }
        }

        return $string;
    }
}
