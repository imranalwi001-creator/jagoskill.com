<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\File;

class TranslateToIndonesian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically translates lang/en to lang/id using Google Translate API';

    protected $translator;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Starting Translation to Indonesian (ID)...");

        // Use Stichoza Google Translate
        $this->translator = new GoogleTranslate('id');
        $this->translator->setSource('en');

        $sourcePath = base_path('lang/en');
        $targetPath = base_path('lang/id');

        if (!File::isDirectory($sourcePath)) {
            $this->error("Source directory lang/en not found!");
            return Command::FAILURE;
        }

        if (!File::isDirectory($targetPath)) {
            File::makeDirectory($targetPath, 0755, true);
        }

        $files = File::allFiles($sourcePath);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $targetFile = $targetPath . '/' . $relativePath;
            $targetDir = dirname($targetFile);

            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            // Skip if the file already exists to avoid overwriting unless we want to force
            // But we might want to force for a fresh install. We'll overwrite for now.
            $this->info("Translating: " . $relativePath);

            $sourceArray = require $file->getPathname();
            
            if (!is_array($sourceArray)) {
                continue;
            }

            $translatedArray = $this->translateArray($sourceArray, $relativePath);

            $this->saveArrayToFile($targetFile, $translatedArray);
            
            $this->info("Completed: " . $relativePath);
        }

        $this->info("All files have been translated to Indonesian successfully!");
        return Command::SUCCESS;
    }

    protected function translateArray(array $array, $filename)
    {
        $translated = [];
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $translated[$key] = $this->translateArray($value, $filename);
            } elseif (is_string($value) && !empty(trim($value))) {
                try {
                    // Extract placeholders like :name or :amount
                    preg_match_all('/:[a-zA-Z0-9_]+/', $value, $matches);
                    $placeholders = $matches[0];
                    
                    // Replace placeholders with temporary unique markers (e.g., __0__, __1__)
                    $tempValue = $value;
                    foreach ($placeholders as $index => $placeholder) {
                        $tempValue = str_replace($placeholder, "__X{$index}X__", $tempValue);
                    }
                    
                    // Also protect blade/vue style {{ $var }} if any
                    preg_match_all('/\{\{.*?\}\}/', $tempValue, $bladeMatches);
                    $bladePlaceholders = $bladeMatches[0];
                    foreach ($bladePlaceholders as $index => $placeholder) {
                        $tempValue = str_replace($placeholder, "__Y{$index}Y__", $tempValue);
                    }

                    // Translate the text
                    $translatedText = $this->translator->translate($tempValue);
                    
                    // Restore blade placeholders
                    foreach ($bladePlaceholders as $index => $placeholder) {
                        $translatedText = str_replace("__Y{$index}Y__", $placeholder, $translatedText);
                        // Also check for lowercase/spaces if google translate mutated it
                        $translatedText = str_replace("__ y{$index}y __", $placeholder, $translatedText);
                        $translatedText = str_replace("__y{$index}y__", $placeholder, $translatedText);
                        $translatedText = str_replace("__ Y{$index}Y __", $placeholder, $translatedText);
                    }

                    // Restore :placeholders
                    foreach ($placeholders as $index => $placeholder) {
                        $translatedText = str_replace("__X{$index}X__", $placeholder, $translatedText);
                        $translatedText = str_replace("__ x{$index}x __", $placeholder, $translatedText);
                        $translatedText = str_replace("__x{$index}x__", $placeholder, $translatedText);
                        $translatedText = str_replace("__ X{$index}X __", $placeholder, $translatedText);
                    }

                    $translated[$key] = $translatedText;
                    
                    // Small delay to prevent rate limiting
                    usleep(50000); // 50ms
                } catch (\Exception $e) {
                    $this->error("Failed to translate key [{$key}] in {$filename}. Keeping original.");
                    $translated[$key] = $value;
                }
            } else {
                $translated[$key] = $value;
            }
        }

        return $translated;
    }

    protected function saveArrayToFile($filePath, array $array)
    {
        $export = var_export($array, true);
        
        // Format the array nicely to standard PHP array syntax [...] instead of array(...)
        $export = preg_replace("/^([ ]*)array \(/m", "$1[", $export);
        $export = preg_replace("/^([ ]*)\)/m", "$1]", $export);
        
        $content = "<?php\n\nreturn " . $export . ";\n";
        
        File::put($filePath, $content);
    }
}
