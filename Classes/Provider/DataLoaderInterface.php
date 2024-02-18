<?php
namespace Provider;

/**
 * Interface pour les classes de chargement de données
 * 
 */
interface DataLoaderInterface {

    /**
     * Récupère les données
     * 
     * @return array
     */
    public function getData(): array;
}

?>