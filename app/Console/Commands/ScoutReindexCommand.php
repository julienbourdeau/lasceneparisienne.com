<?php
//
//namespace App\Console\Commands;
//
//use Algolia\AlgoliaSearch\SearchClient;
//use App\Event;
//use Illuminate\Contracts\Events\Dispatcher;
//use Laravel\Scout\Console\ImportCommand;
//use Laravel\Scout\Searchable;
//use Symfony\Component\Finder\Finder;
//
//class ScoutReindexCommand extends ImportCommand
//{
//    protected $signature = 'scout:reindex';
//
//    protected $description = 'Custom Algolia reindex';
//
//    private static $declaredClasses;
//
//    public function __construct()
//    {
//        parent::__construct();
//        $this->client = SearchClient::create(config('scout.algolia.id'), config('scout.algolia.secret'));
//    }
//
//    /**
//     * Execute the console command.
//     *
//     * @return mixed
//     */
//    public function handle(Dispatcher $events)
//    {
//        foreach ($this->getSearchableModels() as $class) {
//            $this->line('');
//            $this->line('Importing [<comment>'.$class.'</comment>]');
//            $this->currentModel = $class;
//            $model = new $class;
//
//            $indexName = $model->searchableAs();
//            $index = $this->client->initIndex($indexName);
//            $this->line('Clear existing records in <comment>'.$indexName.'</comment>.');
//            $index->clearObjects();
//            $this->line('Import settings...');
//            $index->setSettings($model->getAlgoliaIndexSettings())->wait();
//
//            // Import with original Scout command
//            parent::handle($events);
//        }
//    }
//
//    public function argument($key = null)
//    {
//        if ('model' === $key) {
//            return $this->currentModel;
//        }
//
//        return parent::argument($key);
//    }
//
//    protected function getSearchableModels()
//    {
//        $appNamespace = $this->laravel->getNamespace();
//
//        return array_values(array_filter($this->getProjectClasses(), function (string $class) use ($appNamespace) {
//            return str_start($class, $appNamespace) && $this->isSearchableModel($class);
//        }));
//    }
//
//    protected function isSearchableModel($class): bool
//    {
//        return in_array(Searchable::class, class_uses_recursive($class), true);
//    }
//
//    protected function getProjectClasses(): array
//    {
//        if (self::$declaredClasses === null) {
//            $configFiles = Finder::create()->files()->name('*.php')->in($this->laravel->path());
//
//            foreach ($configFiles->files() as $file) {
//                require_once $file;
//            }
//
//            self::$declaredClasses = get_declared_classes();
//        }
//
//        return self::$declaredClasses;
//    }
//}
