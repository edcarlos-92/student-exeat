<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit142bdc7e92514f07f06e4d0ddcc1263e
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit142bdc7e92514f07f06e4d0ddcc1263e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit142bdc7e92514f07f06e4d0ddcc1263e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
