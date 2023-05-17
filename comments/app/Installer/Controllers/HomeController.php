<?php

namespace App\Installer\Controllers;

use App\Installer\Helpers\PermissionsChecker;
use App\Installer\Helpers\RequirementsChecker;

class HomeController extends InstallerController
{
    public function index(RequirementsChecker $rChecker, PermissionsChecker $pChecker)
    {
        $activation = true;

        $requirements = $rChecker->check(
            $this->requirements
        );

        $permissions = $pChecker->check(
            $this->permissions
        );

        return view('installer.pages.index', compact('requirements', 'permissions', 'activation'));
    }
}
