<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Managers\UploadManager;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class SettingsController extends AdminController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo_admin', ['only' => [
            'update',
        ]]);
    }

    /**
     * Show Comments lists
     *
     * @return void
     */
    public function index()
    {
        return view('admin.pages.settings');
    }

    /**
     * Show a User
     *
     * @return void
     */
    public function update(Request $request)
    {
        $data = $request->all();

        if ($domains = Arr::get($data, 'ALLOWED_DOMAINS')) {
            $sites = "";
            foreach (explode("\r\n", $domains) as $line) {
                if (!empty($line)) {
                    $line = str_replace("http://", "", $line);
                    $line = str_replace("https://", "", $line);
                    $line = rtrim($line, "/");
                    $line = ltrim($line, "/");
                    $sites = $sites . "$line,";
                }
            }

            $data["ALLOWED_DOMAINS"] = $sites;
        }

        if ($request->hasFile('APP_LOGO')) {
            try {
                $image = new UploadManager();
                $image->path('upload/logo')
                    ->file('APP_LOGO')
                    ->name('logo-' . time())
                    ->mime('png')
                    ->move();

                $data["APP_LOGO"] = url($image->getFullUrl());
            } catch (\Exception $e) {
                unset($data["APP_LOGO"]);
            }
        }

        if (isset($data['COMMENTS_HEADCODE'])) {
            $data['COMMENTS_HEADCODE'] = rawurlencode($data['COMMENTS_HEADCODE']);
        }
        if (isset($data['COMMENTS_FOOTERCODE'])) {
            $data['COMMENTS_FOOTERCODE'] = rawurlencode($data['COMMENTS_FOOTERCODE']);
        }

        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $file = DotenvEditor::setKey($key, $value);
            } else {
                $file = DotenvEditor::deleteKey($key);
            }
        }

        $file->save();

        if ($request->expectsJson()) {
            return ['status' => 'success', 'message' => __('Settings successfully saved')];
        }

        return redirect('/admin/settings/');
    }
}
