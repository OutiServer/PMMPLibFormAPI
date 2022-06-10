<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JetBrains\PhpStorm\ArrayShape;

class ContentStepSlider extends BaseContent
{
    /**
     * ステップ
     *
     * @var string[]
     */
    private array $steps;

    /**
     * デフォルト値
     *
     * @var int
     */
    private int $default;

    /**
     * @param string $text
     * @param string[] $steps
     * @param int $default
     */
    public function __construct(string $text, array $steps, int $default = 0)
    {
        parent::__construct($text);

        $this->steps = $steps;
        $this->default = $default;
    }

    #[ArrayShape(["type" => "string", "text" => "string", "steps" => "string[]", "default" => "int"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "step_slider",
            "text" => $this->text,
            "steps" => $this->steps,
            "default" => $this->default
        );
    }
}