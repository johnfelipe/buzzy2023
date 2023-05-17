<?php

namespace App\Installer\Controllers;

use App\Installer\InstallerConfig;
use Laravel\Lumen\Routing\Controller;

class InstallerController extends Controller
{
    public $version;

    public $permissions;

    public $requirements;

    public $upgrade;

    public function __construct(InstallerConfig $config)
    {
        $this->version = $config::$version;
        $this->permissions = $config::$permissions;
        $this->requirements = $config::$requirements;
        $this->upgrade = $config::$upgrade;
    }
}
