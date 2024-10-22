<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitac5f2c652407ae52c92d661588a8a3a0
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Morris\\Mpesa\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Morris\\Mpesa\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitac5f2c652407ae52c92d661588a8a3a0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitac5f2c652407ae52c92d661588a8a3a0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitac5f2c652407ae52c92d661588a8a3a0::$classMap;

        }, null, ClassLoader::class);
    }
}
