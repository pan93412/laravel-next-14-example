<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

use Closure;

class ComposerStaticIniteaf7eeb0d0f055101cfeffefee04a2a0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pan93412\\Magical\\' => 17,
            'Pan93412\\MagicalExtra\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pan93412\\Magical\\' => 
        array (
            0 => __DIR__ . '/..' . '/pan93412/magical/src',
        ),
        'Pan93412\\MagicalExtra\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteaf7eeb0d0f055101cfeffefee04a2a0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteaf7eeb0d0f055101cfeffefee04a2a0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteaf7eeb0d0f055101cfeffefee04a2a0::$classMap;

        }, null, ClassLoader::class);
    }
}
