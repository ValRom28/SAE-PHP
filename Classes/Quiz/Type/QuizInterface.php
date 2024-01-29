<?php
declare(strict_types=1);

namespace Quiz\Type;

interface QuizInterface
{
    public function render();

    public function setAnswer($answer);

    public function isCorrect();
}