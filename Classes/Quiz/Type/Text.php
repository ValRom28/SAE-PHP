<?php
declare(strict_types=1);

namespace Quiz\Type;

final class Text extends Quiz 
{
    private string $type = 'text';

    public function render()
    {
        $content = sprintf(
            '
                <label for="%s">%s</label><br />
                <input type="text" id="%s" name="quiz[%s]">
            ',
            $this->getUuid(),
            $this->getLabel(),
            $this->getUuid(),
            $this->getUuid()
        );

        return $content;
    }
}
