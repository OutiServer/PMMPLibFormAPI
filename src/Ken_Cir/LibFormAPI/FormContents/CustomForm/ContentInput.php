<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JetBrains\PhpStorm\ArrayShape;

class ContentInput extends BaseContent
{
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

    public function __construct(string $text, string $placeholder = "", string $default = "")
    {
        parent::__construct($text);

        $this->placeholder = $placeholder;
        $this->default = $default;
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