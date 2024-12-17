<?php

declare(strict_types=1);

namespace FahemDev\ExtraIcons;

use BladeUI\Icons\Factory;
use Fahemdev\ExtraIcons\Console\Commands\PublishIconResourcesCommand;
use Filament\Panel;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class ExtraIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config');

            $factory->add('bootstrapicons', array_merge(['path' => __DIR__ . '/../resources/svg/bootstrapicons'], $config->get('extra-icons.bootstrapicons', [])));
            $factory->add('feathericons', array_merge(['path' => __DIR__ . '/../resources/svg/feathericons'], $config->get('extra-icons.feathericons', [])));
            $factory->add('ionicons', array_merge(['path' => __DIR__ . '/../resources/svg/ionicons'], $config->get('extra-icons.ionicons', [])));
            $factory->add('tablericons', array_merge(['path' => __DIR__ . '/../resources/svg/tablericons'], $config->get('extra-icons.tablericons', [])));
            $factory->add('octicons', array_merge(['path' => __DIR__ . '/../resources/svg/octicons'], $config->get('extra-icons.octicons', [])));
            $factory->add('antdesign', array_merge(['path' => __DIR__ . '/../resources/svg/antdesignicons'], $config->get('extra-icons.antdesign', [])));
            $factory->add('hugeicons', array_merge(['path' => __DIR__ . '/../resources/svg/hugeicons'], $config->get('extra-icons.hugeicons', [])));
            $factory->add('fontawesome-brands', array_merge(['path' => __DIR__ . '/../resources/svg/fontawesome/brands'], $config->get('extra-icons.fontawesome.brands', [])));
            $factory->add('fontawesome-regular', array_merge(['path' => __DIR__ . '/../resources/svg/fontawesome/regular'], $config->get('extra-icons.fontawesome.regular', [])));
            $factory->add('fontawesome-solid', array_merge(['path' => __DIR__ . '/../resources/svg/fontawesome/solid'], $config->get('extra-icons.fontawesome.solid', [])));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/extra-icons.php', 'extra-icons');
    }

    public function boot(): void
    {
        // Register the plugin with all Filament panels
        $this->app->booted(function () {
            $panels = $this->app->make('filament')->getPanels();

            foreach ($panels as $panel) {
                $this->registerPluginWithPanel($panel);
            }
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishIconResourcesCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/extra-icons'),
            ], 'extra-icons');

            $this->publishes([
                __DIR__ . '/../config/extra-icons.php' => $this->app->configPath('extra-icons.php'),
            ], 'extra-icons-config');
        }
    }

    private function registerPluginWithPanel(Panel $panel): void
    {
        $panel->plugin(ExtraIcons::make());
    }
}
