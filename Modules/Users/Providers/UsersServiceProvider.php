<?php

namespace Modules\Users\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class UsersServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Users';
    protected string $moduleNameLower = 'users';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register(): void
    {
        // Carga el RouteServiceProvider si lo tienes
        if (class_exists($this->moduleNamespace().'\\RouteServiceProvider')) {
            $this->app->register($this->moduleNamespace().'\\RouteServiceProvider');
        }
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path("{$this->moduleNameLower}.php"),
        ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }

    public function registerViews(): void
    {
        $viewPath = resource_path("views/modules/{$this->moduleNameLower}");
        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', "{$this->moduleNameLower}-module-views"]);

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths(), [$sourcePath]),
            $this->moduleNameLower
        );
    }

    public function registerTranslations(): void
    {
        $langPath = resource_path("lang/modules/{$this->moduleNameLower}");

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    public function provides(): array
    {
        return [];
    }

    protected function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir("{$path}/modules/{$this->moduleNameLower}")) {
                $paths[] = "{$path}/modules/{$this->moduleNameLower}";
            }
        }
        return $paths;
    }

    protected function moduleNamespace(): string
    {
        return "Modules\\{$this->moduleName}\\Providers";
    }
}
