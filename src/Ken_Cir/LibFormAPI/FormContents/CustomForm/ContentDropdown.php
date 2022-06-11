<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use InvalidArgumentException;
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

        if ($default < 0 or count($options) <= $default) throw new InvalidArgumentException("default must be greater than or equal to 0 and less than or equal to " . count($options));

        $this->options = $options;
        $this->default = $default;
    }

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }


    /**
     * @return int
     */
    public function getDefault(): int
    {
        return $this->default;
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