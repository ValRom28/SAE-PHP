<?php
declare(strict_types=1);

namespace View;

/**
 * Classe pour les templates
 * 
 */
final class Template {
    private string $path;
    private string $layout;
    private string $header;
    private string $aside;
    private string $content;

    /**
     * Constructeur de la classe
     * 
     * @param string $path
     */
    public function __construct(string $path) {
        $this->path = $path;
    }

    /**
     * Retourne le chemin
     * 
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * Retourne le layout
     * 
     * @return string
     */
    public function getLayout(): string {
        return $this->layout;
    }

    /**
     * Définit le layout
     * 
     * @param string $layout
     * @return self
     */
    public function setLayout(string $layout): self {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Retourne le contenu
     * 
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * Définit le contenu
     * 
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self {
        $this->content = $content;

        return $this;
    }

    /**
     * Retourne le header
     * 
     * @return string
     */
    public function getHeader(): string {
        return $this->header;
    }

    /**
     * Définit le header
     * 
     * @param string $header
     * @return self
     */
    public function setHeader(string $header): self {
        $this->header = $header;

        return $this;
    }

    /**
     * Retourne l'aside
     * 
     * @return string
     */
    public function getAside(): string {
        return $this->aside;
    }

    /**
     * Définit l'aside
     * 
     * @param string $aside
     * @return self
     */
    public function setAside(string $aside): self {
        $this->aside = $aside;

        return $this;
    }

    /**
     * Compile le template
     * 
     * @return string
     */
    public function compile(): string {
        $content = $this->getContent();
        $header = $this->getHeader();
        $aside = $this->getAside();
        ob_start();
        require sprintf(
            '%s/%s.php',
            $this->getPath(),
            $this->getLayout(),
            $this->getHeader(),
            $this->getAside()
        );
        return ob_get_clean();
    }

}
