<?php
declare(strict_types=1);

namespace Quiz\Type;
use function Debug\dd;
use Quiz\Exception\QuizFactoryException;

final class Factory
{
    public static function create($type, $values)
    {
        $className = 'Quiz\\Type\\'.ucfirst($type); 

        try {
            return new $className($values); 
        } catch (\Throwable $th) {
            throw new QuizFactoryException(sprintf('Classname "%s" does not exist', $className));
        }
    }
}
