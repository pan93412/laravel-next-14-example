<?php

// autoload_real.php @generated by Composer

use Composer\Autoload\ClassLoader;
use Composer\Autoload\ComposerStaticIniteaf7eeb0d0f055101cfeffefee04a2a0;

class ComposerAutoloaderIniteaf7eeb0d0f055101cfeffefee04a2a0
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderIniteaf7eeb0d0f055101cfeffefee04a2a0', 'loadClassLoader'), true, true);
        self::$loader = $loader = new ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderIniteaf7eeb0d0f055101cfeffefee04a2a0', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(ComposerStaticIniteaf7eeb0d0f055101cfeffefee04a2a0::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
