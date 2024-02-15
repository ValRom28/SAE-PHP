<?php
namespace Provider;

class DataLoaderYaml implements DataLoaderInterface {
    private $data;

    public function __construct(string $filePath) {
        $this->data = self::parseFile($filePath);
    }

    public static function parseFile(string $filePath): array {
        $yamlData = file_get_contents($filePath);
        return self::parseString($yamlData);
    }

    public static function parseString(string $yamlData): array {
        $parsedData = [];
        $currentAlbumId = null;
    
        foreach (explode("\n", $yamlData) as $line) {
            if (empty($line) || $line[0] === '#') {
                continue;
            }
    
            $parts = explode(':', $line, 2);
    
            if (count($parts) !== 2) {
                continue;
            }
    
            $key = trim($parts[0]);
            $value = trim($parts[1]);
    
            if ($key === "- by") {
                $currentAlbumId = $value;
                $parsedData[$currentAlbumId] = [];
                $parsedData[$currentAlbumId]["by"] = $value;
                $parsedData[$currentAlbumId]["genre"] = [];
            } elseif ($key === "genre") {
                // Trim and remove empty genres
                $genres = array_filter(array_map('trim', explode(',', $value)));
                if (!empty($genres)) { // Vérifie s'il y a des genres
                    // Merge unique genres to avoid duplicates
                    foreach ($genres as $genre) {
                        // Remove square brackets if present
                        $genre = trim($genre, "[]");
                        // Add genre to the list
                        $parsedData[$currentAlbumId]["genre"][] = $genre;
                    }
                }
            } else {
                $parsedData[$currentAlbumId][$key] = $value;
            }
        }
    
        // Remove duplicate genres within each album entry
        foreach ($parsedData as $album) {
            $album["genre"] = array_unique($album["genre"]);
        }
        
        return $parsedData;
    }
    
    public function getData(): array {
        return $this->data;
    }
}
?>
