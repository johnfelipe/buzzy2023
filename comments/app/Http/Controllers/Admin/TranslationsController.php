<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Managers\TranslationManager;

class TranslationsController extends AdminController
{

    /**
     * @var \App\Managers\TranslationManager
     */
    private $manager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TranslationManager $manager)
    {
        $this->middleware('demo_admin', ['only' => [
            'update',
        ]]);

        $this->manager = $manager;
    }

    /**
     * Show Comments lists
     *
     * @return void
     */
    public function index($locale = 'en')
    {
        if (!in_array($locale, get_available_languages(), true)) {
            return redirect('admin');
        }

        $translations = $this->manager->getTranslationsFromFile($locale);

        return view('admin.pages.translations', compact('translations', 'locale'));
    }

    /**
     * Show a User
     *
     * @return void
     */
    public function update(Request $request, $locale = 'en')
    {
        $data = $request->all();

        try {
            $newTranslations = [];
            $translations = $this->manager->getTranslationsFromFile($locale);

            foreach ($translations as $key => $translation) {
                $newTranslations[$key] = Arr::get($data, Str::slug($translation), $translation);
            }

            $this->manager->exportTranslations($newTranslations, $locale);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => __('Failed to save!')];
        }

        if ($request->expectsJson()) {
            return ['status' => 'success', 'message' => __('Translations successfully saved')];
        }

        return redirect('/admin/translations/');
    }
}
