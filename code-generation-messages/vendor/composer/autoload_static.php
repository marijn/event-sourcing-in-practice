<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite249306b8c7ac427060268586f916aff
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '65fec9ebcfbb3cbb4fd0d519687aea01' => __DIR__ . '/..' . '/danielstjules/stringy/src/Create.php',
        'e050abfbc8f56b7048f9dd6785c2704d' => __DIR__ . '/../..' . '/src/Acme/OnlineShop/messages.php',
        'fab84e1d0e5343ba2e54c79e364c03f2' => __DIR__ . '/../..' . '/src/Acme/Infra/EventSourcing/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Yaml\\' => 23,
            'Stringy\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Stringy\\' => 
        array (
            0 => __DIR__ . '/..' . '/danielstjules/stringy/src',
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
