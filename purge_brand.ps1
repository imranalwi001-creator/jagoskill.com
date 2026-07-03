$directories = @("resources", "app", "routes", "config", "lang", "public")
$extensions = @("*.php", "*.blade.php", "*.js", "*.json", "*.html")

$replacements = @(
    @("Rocket LMS", "JagoSkill Platform"),
    @("Rocket Soft", "JagoSkill"),
    @("rocket-soft.org", "jagoskill.com"),
    @("Rocketsoft", "JagoSkill"),
    @("rocketsoft", "jagoskill"),
    @("rocket-lms", "jagoskill")
)

foreach ($dir in $directories) {
    Write-Host "Scanning directory: $dir"
    $files = Get-ChildItem -Path $dir -Recurse -Include $extensions -File
    foreach ($file in $files) {
        $content = Get-Content -Path $file.FullName -Raw -ErrorAction SilentlyContinue
        if ($null -ne $content) {
            $modified = $false
            foreach ($pair in $replacements) {
                $key = $pair[0]
                $val = $pair[1]
                # Use case-sensitive replace (creplace) so 'Rocketsoft' and 'rocketsoft' replace correctly
                if ($content -cmatch [regex]::Escape($key)) {
                    $content = $content -creplace [regex]::Escape($key), $val
                    $modified = $true
                }
            }
            if ($modified) {
                Set-Content -Path $file.FullName -Value $content -NoNewline
                Write-Host "Updated: $($file.FullName)"
            }
        }
    }
}
Write-Host "Brand purge completed."