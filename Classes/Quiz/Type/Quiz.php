<?php
declare(strict_types=1);

namespace Quiz\Type;

abstract class Quiz implements QuizInterface
{
    private string $uuid;

    private string $type;

    private string $label;

    private string $correct;

    private mixed $answer;

    private bool $required = true;

    public function __construct(array $values)
    {
        $this->uuid = $values['uuid'];
        $this->type = $values['type'];
        $this->label = $values['label'];
        $this->correct = $values['correct'];
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setAnswer(mixed $answer): self
    {
        $this->answer = $answer;
        return $this;
    }

    public function getCorrect(): mixed
    {
        return $this->correct;
    }

    public function isCorrect(): bool
    {
        return $this->answer === $this->getCorrect();
    }

}
