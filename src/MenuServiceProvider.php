<?php
namespace Erendi\Menu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require  __DIR__ . '/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/Views', 'wmenu');

        $this->publishes([
            __DIR__ . '/../config/menu.php'  => config_path('menu.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/Views'   => resource_path('views/vendor/wmenu'),
        ], 'view');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('vendor/erendi-menu'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../migrations/2021_12_11_000001_create_menus_table.php' => database_path('migrations/2021_12_11_000001_create_menus_table.php'),
            __DIR__ . '/../migrations/2021_12_11_000002_create_menu_items_table.php' => database_path('migrations/2021_12_11_000002_create_menu_items_table.php'),
            __DIR__ . '/../migrations/2021_12_11_000003_add-role-id-to-menu-items-table.php' => database_path('2021_12_11_000003_add-role-id-to-menu-items-table.php'),
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('erendi-menu', function () {
            return new WMenu();
        });

        $this->app->make('Erendi\Menu\Controllers\MenuController');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/menu.php',
            'menu'
        );
    }
}
