<?php

namespace App\Installer;

class InstallerConfig
{
    public static $version = '2.2.0';

    public static $permissions = [
        'public/upload/',
        'storage/app/',
        'storage/framework/',
        'storage/logs/',
        '.env'
    ];

    public static $requirements = [
        'openssl',
        'pdo',
        'gd', // intervention/image
        'mbstring',
        'fileinfo', // file_content
    ];

    public static $upgrade = [
        'migrations' => '',
        'seeds' => [],
    ];
}
