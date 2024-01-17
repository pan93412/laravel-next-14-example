<?php

// UNUSED: Replaced with Composer.

spl_autoload_register(function ($class) {
    $prefix = 'Pan93412\\Backend\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("Class $class not found. A bug?");
    }
});
