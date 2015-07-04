<?php

namespace Cornernote\Collections;

use Illuminate\Foundation\AliasLoader;
use Cornernote\Collections\Events\CollectionDeleted;
use Cornernote\Collections\Listeners\CollectionCleanup;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class CollectionsServiceProvider extends ServiceProvider
{

    /**
     * Event Bindings
     * @var array
     */
    protected $listen;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {

        parent::boot($events);
        $this->setRoutes();
        $this->setHelpers();
        $this->setViews();
        $this->setMigrations();
        $this->setLanguage();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setAliases();
        $this->setEventBindings();
    }

    /**
     * Include the Package Routes
     */
    private function setRoutes()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
    }

    /**
     * Include the Package Helpers
     */
    private function setHelpers()
    {
        require __DIR__.'/helpers.php';
    }

    /**
     * Set the Package Views Location
     */
    private function setViews()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'collections');
        \View::addLocation(__DIR__.'/Views');
    }

    /**
     * Set Aliases
     */
    private function setAliases()
    {
        $this->app->booting(function(){
            $loader = AliasLoader::getInstance();
            $loader->alias('PageController', 'Cornernote\Collections\Controllers\PageController');
            $loader->alias('CollectionController', 'Cornernote\Collections\Controllers\CollectionController');
            $loader->alias('ItemController', 'Cornernote\Collections\Controllers\ItemController');
        });
    }


    /**
     * Set Migrations
     * On vendor:publish the package migrations will be added to the main app migrations
     */
    private function setMigrations()
    {
        $this->publishes([
            realpath(__DIR__.'/Migrations') => $this->app->databasePath().'/migrations',
        ]);
    }

    /**
     * Set Language
     */
    private function setLanguage()
    {
        $this->loadTranslationsFrom(__DIR__.'/Language', 'collections');
    }

    /**
     * Set Event Bindings
     */
    private function setEventBindings()
    {
        $this->listen = [
            CollectionDeleted::class => [
                CollectionCleanUp::class,
            ],
        ];
    }

}
