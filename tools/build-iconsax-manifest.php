<?php

declare(strict_types=1);

$iconPath = '/var/www/html/vendor/saade/blade-iconsax/resources/svg';
$manifestPath = '/var/www/html/bootstrap/cache/blade-icons.php';

$output = [];
$exitCode = 0;

exec(
    sprintf(
        "find %s -maxdepth 1 -name '*.svg' -printf '%%f\n'",
        escapeshellarg($iconPath)
    ),
    $output,
    $exitCode
);

if ($exitCode !== 0) {
    fwrite(STDERR, "Unable to scan Iconsax SVG directory.\n");
    exit($exitCode);
}

$icons = array_map(
    static fn (string $file): string => substr($file, 0, -4),
    array_filter($output, static fn (string $file): bool => str_ends_with($file, '.svg'))
);

sort($icons);

$manifest = [
    'iconsax' => [
        $iconPath => $icons,
    ],
];

file_put_contents($manifestPath, '<?php return '.var_export($manifest, true).';');

printf(
    "Generated %d Iconsax icons. %s bol-star-1.\n",
    count($icons),
    in_array('bol-star-1', $icons, true) ? 'Found' : 'Missing'
);
