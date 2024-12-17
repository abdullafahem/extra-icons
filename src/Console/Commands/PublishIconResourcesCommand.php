<?php

namespace Fahemdev\ExtraIcons\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishIconResourcesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extra-icons:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish icon resources for Extra Icons package';

    /**
     * Icon packages available for publishing.
     *
     * @var array
     */
    protected $iconPackages = [
        'bootstrap' => 'Bootstrap Icons',
        'feather' => 'Feather Icons',
        'ion' => 'Ionicons',
        'tabler' => 'Tabler Icons',
        'octicon' => 'Octicons',
        'fontawesome-brands' => 'Font Awesome Brands',
        'fontawesome-regular' => 'Font Awesome Regular',
        'fontawesome-solid' => 'Font Awesome Solid',
        'ant' => 'Ant Design Icons',
        'huge' => 'Huge Icons',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Extra Icons Resource Publisher');
        $this->info('------------------------------');

        $choice = $this->choice(
            'Would you like to publish specific icon packages or all packages?',
            [
                'all' => 'Publish All Packages',
                'select' => 'Select Specific Packages',
            ],
            'all'
        );

        if ($choice === 'all') {
            $this->publishAllPackages();
        } else {
            $this->publishSelectedPackages();
        }
    }

    /**
     * Publish all icon packages.
     *
     * @return void
     */
    protected function publishAllPackages()
    {
        foreach ($this->iconPackages as $package => $name) {
            $this->publishPackage($package, $name);
        }
    }

    /**
     * Allow user to select specific packages to publish.
     *
     * @return void
     */
    protected function publishSelectedPackages()
    {
        $selectedPackages = $this->choice(
            'Select icon packages to publish (use comma to select multiple)',
            $this->iconPackages,
            null,
            null,
            true
        );

        if (empty($selectedPackages)) {
            $this->warn('No packages selected. Publishing all packages by default.');
            $this->publishAllPackages();
            return;
        }

        foreach ($selectedPackages as $package) {
            $this->publishPackage($package, $this->iconPackages[$package]);
        }
    }

    /**
     * Publish a specific icon package.
     *
     * @param string $package
     * @param string $name
     * @return void
     */
    protected function publishPackage(string $package, string $name)
    {
        $this->info("Publishing {$name}...");

        try {
            Artisan::call('vendor:publish', [
                '--tag' => "extra-icons-{$package}",
                '--force' => true
            ]);

            $this->info("{$name} published successfully!");
        } catch (\Exception $e) {
            $this->error("Failed to publish {$name}: " . $e->getMessage());
        }
    }
}
