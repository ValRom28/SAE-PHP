<?php
namespace Provider;

/**
 * Classe pour charger des données depuis un fichier JSON
 * 
 */
final class DataLoaderJson implements DataLoaderInterface {
    private $data;

    /**
     * Constructeur de la classe
     * 
     * @param string $source
     */
    public function __construct(string $source) {
        $content = file_get_contents($source);
        $this->data = json_decode($content, true);
    
        if (empty($this->data)) {
            throw new \Exception(sprintf('No datas in "%s"', $source));
        }
    }

    /**
     * Retourne les données
     * 
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }
}
