<?php

namespace App\Installer\Helpers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class DatabaseManager
{

    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateAndSeed()
    {
        return $this->migrate();
    }


    /**
     * Run the migration and call the seeder.
     *
     * @return array
     */
    private function migrate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }

        return $this->seed();
    }

    /**
     * Seed the database.
     *
     * @return array
     */
    private function seed()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }
        return $this->finish();
    }

    /**
     * Execute migrations and seeders.
     *
     * @return array
     */
    public function updateDatabaseAndSeedTables($migrations = [], $seeds = [])
    {
        // @todo do we need this really?
        try {
            $file = DotenvEditor::setKey('APP_ENV', 'local');
            $file->save();
        } catch (Exception $e) {
        }

        //env('APP_ENV', 'local');
        return $this->updateDatabase($migrations, $seeds);
    }

    /**
     * Update the database.
     *
     * @return array
     */
    private function updateDatabase($migrations = [], $seeds = [])
    {
        if ($migrations && !empty($migrations)) {
            try {
                if (is_array($migrations)) {
                    $database_path = database_path();

                    foreach ($migrations as $key => $value) {
                        Artisan::call('migrate', ['--path' => $database_path . "/migrations/" . $value, '--force' => true]);
                    }
                } else {
                    Artisan::call('migrate', ['--force' => true]);
                }
            } catch (Exception $e) {
                return $this->response($e->getMessage(), 'error');
            }
        }

        return $this->updateSeed($seeds);
    }

    /**
     * Seed the database.
     *
     * @return array
     */
    private function updateSeed($seeds = [])
    {
        if ($seeds && is_array($seeds) && !empty($seeds)) {
            try {
                foreach ($seeds as $key => $value) {
                    Artisan::call('db:seed', ['--class' => $value, '--force' => true]);
                }
            } catch (Exception $e) {
                return $this->response($e->getMessage(), 'error');
            }
        }
        return $this->finish();
    }

    /**
     * Return a formatted error messages.
     *
     * @param  $message
     * @param  string  $status
     * @return array
     */
    private function finish()
    {
        try {
            $file = DotenvEditor::setKey('APP_ENV', 'production');
            $file = DotenvEditor::setKey('APP_KEY', Str::random(32));
            $file->save();

            Cache::flush();
           // env('APP_ENV', 'production');
        } catch (Exception $e) {
           //
        }

        return $this->response(__('Successful'), 'success');
    }

    /**
     * Return a formatted error messages.
     *
     * @param  $message
     * @param  string  $status
     * @return array
     */
    private function response($message, $status = 'error')
    {
        return array(
            'status' => $status,
            'message' => $message
        );
    }
}
