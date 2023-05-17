<?php

namespace App\Installer\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Installer\Helpers\DatabaseManager;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class DatabaseController extends InstallerController
{
	public function post(Request $request, DatabaseManager $manager)
	{
        $validator = Validator::make($request->all(), [
            'host' => 'required',
            'port' => 'required',
            'database' => 'required',
            'username' => 'required',
            'prefix' => 'required',
            'admin_email' => 'required|email',
            'admin_password' => 'required|between:5,20',
        ], [
            'email' => __('This is not a valid email address'),
            'required' => __('The :attribute field is required.'),
            'between' => __('The :attribute value :input is not between :min - :max.'),
        ]);

      if ($validator->fails()) {
            return array(
                'status' => 'error',
                'message' => $validator->errors()->first()
            );
      }

		$db_configs = [
			'connection' => $request->get('connection', 'mysql'),
			'host' => $request->get('host', '127.0.0.1'),
			'port' => $request->get('port', '3306'),
			'database' => $request->get('database'),
			'username' => $request->get('username'),
			'password' => $request->get('password'),
			'prefix' => $request->get('prefix')
		];

		$this->setConfigDynamically($db_configs);

		// test
		try {
			DB::connection()->reconnect();
		} catch (\PDOException $e) {
            return array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
		}

		// save configs
        foreach ($db_configs as $key => $value) {
            $file = DotenvEditor::setKey('DB_'.strtoupper($key), $value);
        }

        $file->save();

		// migrat & seed
		$response = $manager->migrateAndSeed();

		if ($response['status'] == 'error') {
			return $response;
        }

        // migrat & seed
		$response = $this->adminCreate($request->only(['admin_email', 'admin_password']));

		if ($response['status'] == 'error') {
			return $response;
		}

		return $this->finish();
	}

	private function setConfigDynamically($configs)
	{
		$connection = $configs['connection'];
		config(['database.default' => $connection]);
		unset($configs['connection']);

		foreach ($configs as $key => $value) {
			config(['database.connections.'.$connection.'.'.$key => $value]);
		}
	}

	public function adminCreate($user)
	{
		try {
            $username = explode('@', $user['admin_email'])[0];

			DB::table('users')->insert(
                [
                    'user_type' => 'admin',
                    'username' => $username,
                    'username_slug' => $username,
                    'email' => $user['admin_email'],
                    'password' => bcrypt($user['admin_password']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                 ]
            );
		} catch (\Exception $e) {
			return array(
                'status' => 'error',
                'message' =>$e->getMessage()
            );
		}

		return array(
            'status' => 'success',
        );
    }

	public function finish()
	{
		try {
            @file_put_contents(storage_path('installed'), $this->version);
		} catch (\Exception $e) {
			return array(
                'status' => 'error',
                'message' =>$e->getMessage()
            );
		}

		return array(
            'status' => 'success',
            'message' => __('Sucessfully installed.'),
            'redirectTo' => url('api/login')
        );
	}
}
