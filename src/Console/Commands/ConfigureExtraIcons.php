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
}
