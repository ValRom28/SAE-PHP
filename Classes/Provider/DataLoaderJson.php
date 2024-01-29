<?php
declare(strict_types=1);

namespace Provider;

final class DataLoaderJson implements DataLoaderInterface
{
    private $data;

    public function __construct(string $source)
    {
        $content = file_get_contents($source);
        $this->data = json_decode($content, true);
    
        if (empty($this->data)) {
            throw new \Exception(sprintf('No question in "%s"', $source));
        }
    }

    public function getData(): array
    {
        return $this->data;
    }
}
