<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JetBrains\PhpStorm\ArrayShape;

class ContentInput extends BaseContent
{
    public const TYPE_STRING = 0;

    public const TYPE_INT = 1;

    public const TYPE_PLAYER = 2;

    /**
     * プレースホルダー
     *
     * @var string
     */
    private string $placeholder;

    /**
     * デフォルト値
     *
     * @var string
     */
    private string $default;

    /**
     * このInputが必須であるか
     *
     * @var bool
     */
    private bool $requirement;

    /**
     * 型
     * @var int
     */
    private int $inputType;


    public function __construct(string $text, string $placeholder = "", string $default = "", bool $requirement = true, int $inputType = self::TYPE_STRING)
    {
        parent::__construct($text);

        $this->placeholder = $placeholder;
        $this->default = $default;
        $this->requirement = $requirement;
        $this->inputType = $inputType;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * @return string
     */
    public function getDefault(): string
    {
        return $this->default;
    }

    /**
     * @return bool
     */
    public function isRequirement(): bool
    {
        return $this->requirement;
    }

    /**
     * @return int
     */
    public function getInputType(): int
    {
        return $this->inputType;
    }

    #[ArrayShape(["type" => "string", "text" => "string", "placeholder" => "string", "default" => "string"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "input",
            "text" => $this->text,
            "placeholder" => $this->placeholder,
            "default" => $this->default
        );
    }
}