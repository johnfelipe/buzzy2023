<?php

namespace App\Installer\Controllers;

use Illuminate\Support\Facades\Session;
use App\Installer\Helpers\DatabaseManager;

class UpdateController extends InstallerController
{
	public function update()
	{
		return view('installer.pages.update');
	}

	public function update_init(DatabaseManager $manager)
	{
		$response = $manager->updateDatabaseAndSeedTables($this->upgrade['migrations'], $this->upgrade['seeds']);

		// upgrade
		if ($response['status'] == 'error') {
			return $response;
		}

		@file_put_contents(storage_path('installed'), $this->version);

		return $response;
	}
}
