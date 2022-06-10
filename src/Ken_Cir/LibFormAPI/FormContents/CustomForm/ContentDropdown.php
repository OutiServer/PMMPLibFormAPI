<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JetBrains\PhpStorm\ArrayShape;

class ContentDropdown extends BaseContent
{
    /**
     * 選択肢
     *
     * @var string[]
     */
    private array $options;

    /**
     * デフォルト値
     *
     * @var int
     */
    private int $default;

    /**
     * @param string $text
     * @param string[] $options
     * @param int $default
     */
    public function __construct(string $text, array $options, int $default = 0)
    {
        parent::__construct($text);

        $this->options = $options;
        $this->default = $default;
    }

    #[ArrayShape(["type" => "string", "text" => "string", "options" => "string[]", "default" => "int"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "dropdown",
            "text" => $this->text,
            "options" => $this->options,
            "default" => $this->default
        );
    }
}