<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite249306b8c7ac427060268586f916aff
{
    public static $files = array (
        'e050abfbc8f56b7048f9dd6785c2704d' => __DIR__ . '/../..' . '/src/Acme/OnlineShop/messages.php',
        'fab84e1d0e5343ba2e54c79e364c03f2' => __DIR__ . '/../..' . '/src/Acme/Infra/EventSourcing/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Yaml\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
    );

    public static $prefixesPsr0 = array (
        'A' => 
        array (
            'Acme\\' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite249306b8c7ac427060268586f916aff::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite249306b8c7ac427060268586f916aff::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite249306b8c7ac427060268586f916aff::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
