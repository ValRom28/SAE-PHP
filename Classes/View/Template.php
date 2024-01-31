<?php
declare(strict_types=1);

namespace View;
final class Template
{
    private string $path;
    private string $layout;
    private string $header;
    private string $aside;
    private string $content;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function setLayout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function getAside(): string
    {
        return $this->aside;
    }

    public function setAside(string $aside): self
    {
        $this->aside = $aside;

        return $this;
    }

    public function compile(): string
    {
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
