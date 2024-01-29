<?php
declare(strict_types=1);

namespace View;
final class Template
{
    /**
     * @var string
     */
    private string $path;

    /**
     * @var string
     */
    private string $layout;

    /**
     * @var string
     */
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

    public function compile(): string
    {
        $content = $this->getContent();
        ob_start();
        require sprintf(
            '%s/%s.php',
            $this->getPath(),
            $this->getLayout()
        );
        return ob_get_clean();
    }

}
