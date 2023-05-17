<?php

namespace App\Console\Commands;

use App\Managers\TranslationManager;
use Illuminate\Console\Command;

class FindTranslations extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'translations:find';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature  = 'translations:find {--translate= : Translate to languages use "--translate=all" for all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find translations in php/twig files';

    /** @var \App\Managers\TranslationManager */
    protected $manager;

    public function __construct(TranslationManager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $counter = $this->manager->findTranslations();
        $this->info('Done importing, processed '.$counter.' items!');

        if ($translate = $this->option('translate')) {
            if ($translate ==='all') {
                $translate = implode(',', array_keys(get_translatable_language()));
            }
            $this->line('Translating...');

            $this->call('translations:translate', [
                'locale' => $translate,
                'from' => 'en',
                'force' => 'No',
                'file' => 'json',
                'should_verbose' => 'No'
            ]);
        }

        $this->line('Done translating!');
    }
}
