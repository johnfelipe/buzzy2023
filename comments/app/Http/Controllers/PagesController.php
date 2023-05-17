<?php

namespace App\Http\Controllers;

use App\Page;

class PagesController extends Controller
{
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('auth.pages.page', compact('page'));
    }
}
