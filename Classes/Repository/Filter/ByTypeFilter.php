<?php
declare(strict_types=1);

namespace Repository\Filter;

use Quiz\Quiz;
use FilterIterator;
use function Debug\dd;

final class ByTypeFilter extends FilterIterator
{
    private string $type;

    public function __construct(\Iterator $iterator, string $type)
    {
        parent::__construct($iterator);
        $this->type = $type;    
    }

    public function accept(): bool
    {
        /** @var Quiz $ccurent */
        $current = $this->getInnerIterator()->current();
        dd($current->getType());
        dd($this->type);
        return $current->getType() === $this->type;
    }
}
