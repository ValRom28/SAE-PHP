<?php
declare(strict_types=1);

namespace Repository;

use Quiz\Type\QuizInterface;
use Quiz\Type\Factory;
use ArrayIterator;
use Repository\Filter\ByTypeFilter;
use function Debug\dd;

final class QuestionRepository extends ArrayIterator
{
    public function __construct($array = [], $flags = 0)
    {
        foreach ($array as $value) {
            $quizz = Factory::create($value['type'], $value);
            $this->append($quizz);
        }
    }

    public function find(string $uuid): QuizInterface|false
    {   
        $array = iterator_to_array($this);
        $elements = array_filter($array, function ($obj) use ($uuid) {
            return $obj->getUuid() === $uuid;                
        });

        return array_shift($elements);
    }

    public function findByType(string $type)
    {
        return new ByTypeFilter($this, $type);
    }
}
