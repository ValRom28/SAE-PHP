<?php
declare(strict_types=1);

namespace Quiz\Type;

final class Radio extends Quiz 
{
    private string $type = 'radio';

    private array $choices;

    public function __construct(array $values)
    {
        $this->choices = $values['choices'];

        parent::__construct($values);
    }

    public function render()
    {
        $choices = null;
        foreach ($this->choices as $k => $choice) {
            $key = $this->getUuid().'_'.$k;
            $choices .= sprintf(
                '<label for="%s">%s</label>
                <input type="radio" id="%s" name="quiz[%s]" value="%s">',
                $key, $choice, $key, $this->getUuid(), $choice
            );
        }
        $content = sprintf(
            '
                <label for="%s">%s</label><br />
                %s
            ',
            $this->getUuid(),
            $this->getLabel(),
            $choices
        );

        return $content;
    }
}
