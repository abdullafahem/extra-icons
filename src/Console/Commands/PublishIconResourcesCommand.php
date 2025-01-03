<?php

namespace Fahemdev\ExtraIcons\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        'bootstrap' => [
            'name' => 'Bootstrap Icons',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/bootstrapicons',
            'destination' => 'extra-icons/resources/bootstrap'
        ],
        'feather' => [
            'name' => 'Feather Icons',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/feathericons',
            'destination' => 'extra-icons/resources/feather'
        ],
        'ion' => [
            'name' => 'Ionicons',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/ionicons',
            'destination' => 'extra-icons/resources/ion'
        ],
        'tabler' => [
            'name' => 'Tabler Icons',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/tablericons',
            'destination' => 'extra-icons/resources/tabler'
        ],
        'octicon' => [
            'name' => 'Octicons',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/octicons',
            'destination' => 'extra-icons/resources/octicon'
        ],
        'fontawesome-brands' => [
            'name' => 'Font Awesome Brands',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/fontawesome/brands',
            'destination' => 'extra-icons/resources/fontawesome-brands'
        ],
        'fontawesome-regular' => [
            'name' => 'Font Awesome Regular',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/fontawesome/regular',
            'destination' => 'extra-icons/resources/fontawesome-regular'
        ],
        'fontawesome-solid' => [
            'name' => 'Font Awesome Solid',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/fontawesome/solid',
            'destination' => 'extra-icons/resources/fontawesome-solid'
        ],
        'ant' => [
            'name' => 'Ant Design Icons',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/antdesignicons',
            'destination' => 'extra-icons/resources/ant'
        ],
        'huge' => [
            'name' => 'Huge Icons',
            'source' => 'vendor/fahemdev/extra-icons/resources/svg/hugeicons',
            'destination' => 'extra-icons/resources/huge'
        ]
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
                '0' => 'Publish All Packages',
                '1' => 'Select Specific Packages',
            ],
            '0'
        );

        if ($choice === '0') {
            $this->publishAllPackages();
        } else {
            $this->publishSelectedPackages();
        }

        $this->info('Icon resources published successfully!');
    }

    /**
     * Publish all icon packages.
     *
     * @return void
     */
    protected function publishAllPackages()
    {
        foreach ($this->iconPackages as $package => $details) {
            $this->publishPackage($package, $details);
        }
    }

    /**
     * Allow user to select specific packages to publish.
     *
     * @return void
     */
    protected function publishSelectedPackages()
    {
        $packageOptions = array_keys($this->iconPackages);
        $packageNames = array_column($this->iconPackages, 'name');

        $selectedPackageNames = $this->choice(
            'Select icon packages to publish (use comma to select multiple)',
            $packageNames,
            null,
            null,
            true
        );

        if (empty($selectedPackageNames)) {
            $this->warn('No packages selected. Publishing all packages by default.');
            return;
        }

        foreach ($selectedPackageNames as $selectedName) {
            $packageIndex = array_search($selectedName, $packageNames);
            if ($packageIndex !== false) {
                $package = $packageOptions[$packageIndex];
                $this->publishPackage($package, $this->iconPackages[$package]);
            }
        }
    }

    /**
     * Publish a specific icon package.
     *
     * @param string $package
     * @param array $details
     * @return void
     */
    protected function publishPackage(string $package, array $details)
    {
        $sourcePath = base_path($details['source']);
        $destinationPath = resource_path($details['destination']);

        if (!File::exists($sourcePath)) {
            $this->error("Source path for {$details['name']} does not exist: {$sourcePath}");
            return;
        }

        // Ensure destination directory exists
        File::makeDirectory($destinationPath, 0755, true, true);

        // Copy icon files
        File::copyDirectory($sourcePath, $destinationPath);

        $this->info("Published {$details['name']} to resources/{$details['destination']}");
    }
}
