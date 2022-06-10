<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JetBrains\PhpStorm\ArrayShape;

class ContentSlider extends BaseContent
{
    /**
     * 最小
     *
     * @var float
     */
    private float $min;

    /**
     * 最大
     *
     * @var float
     */
    private float $max;

    /**
     * 進み具合？
     *
     * @var float
     */
    private float $step;

    /**
     * デフォルト値
     *
     * @var float
     */
    private float $default;

    public function __construct(string $text, float $min, float $max, float $step = 1.0, float $default = null)
    {
        parent::__construct($text);

        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        if ($default !== null) $this->default = $default;
        else $this->default = $min;
    }

    #[ArrayShape(["type" => "string", "text" => "string", "min" => "float", "max" => "float", "step" => "float|null", "default" => "float"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "slider",
            "text" => $this->text,
            "min" => $this->min,
            "max" => $this->max,
            "step" => $this->step,
            "default" => $this->default
        );
    }
}