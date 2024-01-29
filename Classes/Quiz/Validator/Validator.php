<?php
declare(strict_types=1);

namespace Quiz\Validator;
use Repository\QuestionRepository;

final class Validator
{
    public function __construct(
        private readonly QuestionRepository $questionRepository,
        private readonly array $responses
    ) 
    {}
    

}
