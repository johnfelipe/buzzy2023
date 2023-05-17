<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class ThemesController extends AdminController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo_admin', ['only' => [
            'selectTheme',
        ]]);
    }

    /**
     * Show Themes lists
     *
     * @return void
     */
    public function index()
    {
        $currentTheme = env('COMMENTS_THEME', 'Default');
        $themes = get_available_themes();

        return view('admin.pages.themes', compact('currentTheme', 'themes'));
    }

    /**
     * Select a Theme
     *
     * @return void
     */
    public function selectTheme($theme)
    {
        if (!$theme || !in_array($theme, get_available_themes(), true)) {
            return ['status' => 'error', 'message' => __('Not a Valid Theme')];
        }

        $file = DotenvEditor::setKey('COMMENTS_THEME', $theme);
        $file->save();

        return ['status' => 'success', 'message' => $theme];
    }
}
