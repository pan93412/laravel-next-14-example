<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

use Closure;

class ComposerStaticInitb8b195cbb1585425944028f821d7f29f
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pan93412\\Magical\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pan93412\\Magical\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitb8b195cbb1585425944028f821d7f29f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb8b195cbb1585425944028f821d7f29f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb8b195cbb1585425944028f821d7f29f::$classMap;

        }, null, ClassLoader::class);
    }
}
