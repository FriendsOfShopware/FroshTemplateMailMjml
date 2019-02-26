<?php

namespace FroshTemplateMailMjml\Components;

use FroshTemplateMail\Components\Loader\MailLoaderInterface;
use Shopware\Models\Mail\Mail;

/**
 * Class MjmlMailLoader
 *
 * @author Soner Sayakci <shyim@posteo.de>
 */
class MjmlMailLoader implements MailLoaderInterface
{
    /**
     * @var MjmlCompilerInterface
     */
    private $compiler;

    /**
     * MjmlMailLoader constructor.
     *
     * @param MjmlCompilerInterface $compiler
     *
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(MjmlCompilerInterface $compiler)
    {
        $this->compiler = $compiler;
    }

    /**
     * This method returns extensions which can be handled by the loader
     *
     * @return array
     *
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function canHandleExtensions()
    {
        return ['mjml'];
    }

    /**
     * @param Mail   $mail
     * @param string $templatePath
     * @param string $resolvedTemplatePath
     *
     * @throws CompileErrorException
     *
     * @return string
     *
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function loadMail(Mail $mail, $templatePath, $resolvedTemplatePath)
    {
        return $this->compiler->compile($resolvedTemplatePath);
    }
}
