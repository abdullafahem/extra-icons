<?php

namespace FahemDev\ExtraIcons\Console\Commands;

use Illuminate\Console\Command;

class ConfigureExtraIcons extends Command
{
    protected $signature = 'extra-icons:configure';
    protected $description = 'Configure ExtraIcons by selecting the desired icon packages';

    public function handle(): int
    {
        $availablePackages = [
            'bootstrapicons',
            'feathericons',
            'ionicons',
            'tablericons',
            'octicons',
            'fontawesome.brands',
            'fontawesome.regular',
            'fontawesome.solid',
            'antdesign',
            'hugeicons',
        ];

        $selectedPackages = $this->choice(
            'Select the icon packages you want to install (use space to select multiple):',
            $availablePackages,
            null,
            null,
            true
        );

        if (empty($selectedPackages)) {
            $this->info('No packages selected, installing all packages.');
            $selectedPackages = $availablePackages;
        }

        foreach ($selectedPackages as $package) {
            $this->info("Copying SVG files for: $package");

            $source = $this->getSourcePath($package);
            $destination = public_path("vendor/extra-icons/$package");

            if (!file_exists($source)) {
                $this->warn("Source path for $package does not exist. Skipping...");
                continue;
            }

            $this->copyDirectory($source, $destination);
        }

        $this->info('Icon packages configured successfully.');
        return 0;
    }

    private function getSourcePath(string $package): string
    {
        return "/../../../resources/svg/$package";
    }

    private function copyDirectory(string $source, string $destination): void
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        foreach (scandir($source) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            copy("$source/$file", "$destination/$file");
        }
    }
}
