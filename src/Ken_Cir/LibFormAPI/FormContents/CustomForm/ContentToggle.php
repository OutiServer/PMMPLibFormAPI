<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JetBrains\PhpStorm\ArrayShape;

class ContentToggle extends BaseContent
{
    /**
     * デフォルト値
     *
     * @var bool
     */
    private bool $default;

    public function __construct(string $text, bool $default = false)
    {
        parent::__construct($text);

        $this->default = $default;
    }

    /**
     * @return bool
     */
    public function getDefault(): bool
    {
        return $this->default;
    }

    #[ArrayShape(["type" => "string", "text" => "string", "default" => "bool"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "toggle",
            "text" => $this->text,
            "default" => $this->default
        );
    }
}