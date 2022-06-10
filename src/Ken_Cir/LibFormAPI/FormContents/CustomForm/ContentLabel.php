<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JetBrains\PhpStorm\ArrayShape;

class ContentLabel extends BaseContent
{
    public function __construct(string $text)
    {
        parent::__construct($text);
    }


    #[ArrayShape(["type" => "string", "text" => "string"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "label",
            "text" => $this->text
        );
    }
}