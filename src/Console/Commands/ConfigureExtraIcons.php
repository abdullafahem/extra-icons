<?php

namespace FahemDev\ExtraIcons\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ConfigureExtraIcons extends Command
{
    protected $signature = 'extra-icons:configure';
    protected $description = 'Configure ExtraIcons by selecting and downloading desired icon packages';

    private string $repoBaseUrl = 'https://github.com/abdullafahem/extra-icons/tree/main/resources/svg';

    private array $iconPackages = [
        'bootstrapicons' => 'bootstrapicons',
        'feathericons' => 'feathericons',
        'ionicons' => 'ionicons',
        'tablericons' => 'tablericons',
        'octicons' => 'octicons',
        'fontawesome.brands' => 'fontawesome-brands',
        'fontawesome.regular' => 'fontawesome-regular',
        'fontawesome.solid' => 'fontawesome-solid',
        'antdesign' => 'antdesign',
        'hugeicons' => 'hugeicons',
    ];

    public function handle(): int
    {
        $selectedPackage = $this->choice(
            'Select the icon package you want to install:',
            array_keys($this->iconPackages),
            null
        );

        if (!$selectedPackage) {
            $this->info('No package selected. Exiting configuration.');
            return 0;
        }

        $this->info("Fetching and installing: $selectedPackage");

        $packageFolder = $this->iconPackages[$selectedPackage];
        $url = "{$this->repoBaseUrl}/{$packageFolder}";
        $destination = public_path("vendor/extra-icons/{$packageFolder}");

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $this->fetchAndStoreIcons($url, $destination);

        $this->info("Icon package '{$selectedPackage}' installed successfully!");
        return 0;
    }

    private function fetchAndStoreIcons(string $url, string $destination): void
    {
        $files = Http::get("{$url}/index.json")->json();

        foreach ($files as $file) {
            $fileContent = Http::get("{$url}/{$file}");
            File::put("{$destination}/{$file}", $fileContent);
        }
    }

    // protected $signature = 'extra-icons:configure';
    // protected $description = 'Configure ExtraIcons by selecting the desired icon packages';

    // public function handle(): int
    // {
    //     $availablePackages = [
    //         'bootstrapicons',
    //         'feathericons',
    //         'ionicons',
    //         'tablericons',
    //         'octicons',
    //         'fontawesome.brands',
    //         'fontawesome.regular',
    //         'fontawesome.solid',
    //         'antdesign',
    //         'hugeicons',
    //     ];

    //     $selectedPackages = $this->choice(
    //         'Select the icon packages you want to install (use space to select multiple):',
    //         $availablePackages,
    //         null,
    //         null,
    //         true
    //     );

    //     if (empty($selectedPackages)) {
    //         $this->info('No packages selected, installing all packages.');
    //         $selectedPackages = $availablePackages;
    //     }

    //     foreach ($selectedPackages as $package) {
    //         $this->info("Copying SVG files for: $package");

    //         $source = $this->getSourcePath($package);
    //         $destination = public_path("vendor/extra-icons/$package");

    //         if (!file_exists($source)) {
    //             $this->warn("Source path for $package does not exist. Skipping...");
    //             continue;
    //         }

    //         $this->copyDirectory($source, $destination);
    //     }

    //     $this->info('Icon packages configured successfully.');
    //     return 0;
    // }

    // private function getSourcePath(string $package): string
    // {
    //     return "/../../../resources/svg/$package";
    // }

    // private function copyDirectory(string $source, string $destination): void
    // {
    //     if (!is_dir($destination)) {
    //         mkdir($destination, 0755, true);
    //     }

    //     foreach (scandir($source) as $file) {
    //         if ($file === '.' || $file === '..') {
    //             continue;
    //         }

    //         copy("$source/$file", "$destination/$file");
    //     }
    // }
}
