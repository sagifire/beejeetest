<?php

namespace app\services;

use app\Application;
use Illuminate\Validation;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Validator
 *
 * @package app\services
 */
class Validator
{
    /**
     * @var Validation\Factory
     */
    private $factory;

    /**
     * Validator constructor.
     */
    public function __construct()
    {
        $this->factory = new Validation\Factory(
            $this->loadTranslator()
        );
    }

    /**
     * @return Translation\Translator
     */
    protected function loadTranslator()
    {
        $filesystem = new Filesystem();
        $loader = new Translation\FileLoader(
            $filesystem, dirname(dirname(__FILE__)) . '/lang');
        $loader->addNamespace(
            'lang',
            dirname(dirname(__FILE__)) . '/lang'
        );
        $loader->load(Application::getInstance()->language, 'validation', 'lang');
        return new Translation\Translator($loader, Application::getInstance()->language);
    }

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array(
            [$this->factory, $method],
            $args
        );
    }
}