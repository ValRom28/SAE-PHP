<?php
declare(strict_types=1);

namespace Provider;

interface DataLoaderInterface
{
    public function getData(): array;
}