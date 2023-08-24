<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitba5f7a31cd1f8775692acc3c6b8c0fab
{
    public static $files = array (
        '2cffec82183ee1cea088009cef9a6fc3' => __DIR__ . '/..' . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
        '7166494aeff09009178f278afd86c83f' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v4p13.php',
    );

    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'eBakim\\' => 7,
        ),
        'Z' => 
        array (
            'ZipStream\\' => 10,
            'Zend\\Stdlib\\' => 12,
            'Zend\\Memory\\' => 12,
            'Zend\\Hydrator\\' => 14,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
            'PhpOffice\\PhpSpreadsheet\\' => 25,
        ),
        'M' => 
        array (
            'Matrix\\' => 7,
        ),
        'E' => 
        array (
            'Endroid\\QrCode\\' => 15,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'C' => 
        array (
            'Complex\\' => 8,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'eBakim\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'ZipStream\\' => 
        array (
            0 => __DIR__ . '/..' . '/maennchen/zipstream-php/src',
        ),
        'Zend\\Stdlib\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-stdlib/src',
        ),
        'Zend\\Memory\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-memory/src',
        ),
        'Zend\\Hydrator\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-hydrator/src',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'PhpOffice\\PhpSpreadsheet\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet',
        ),
        'Matrix\\' => 
        array (
            0 => __DIR__ . '/..' . '/markbaker/matrix/classes/src',
        ),
        'Endroid\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/endroid/qr-code/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'Complex\\' => 
        array (
            0 => __DIR__ . '/..' . '/markbaker/complex/classes/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'Z' => 
        array (
            'ZendPdf\\' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zendpdf/library',
            ),
        ),
        'H' => 
        array (
            'HTMLPurifier' => 
            array (
                0 => __DIR__ . '/..' . '/ezyang/htmlpurifier/library',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitba5f7a31cd1f8775692acc3c6b8c0fab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitba5f7a31cd1f8775692acc3c6b8c0fab::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitba5f7a31cd1f8775692acc3c6b8c0fab::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitba5f7a31cd1f8775692acc3c6b8c0fab::$classMap;

        }, null, ClassLoader::class);
    }
}
