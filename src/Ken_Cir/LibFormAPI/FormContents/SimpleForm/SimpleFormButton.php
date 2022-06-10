<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\SimpleForm;

use JsonSerializable;

/**
 * SimpleFormのButtonオプション
 */
class SimpleFormButton implements JsonSerializable
{
    public const IMAGE_TYPE_PATH = "path";

    public const IMAGE_TYPE_URL = "url";

    private string $text;

    private ?string $iconPath;

    private string $iconType;

    public function __construct(string $text, string $iconPath = null, string $iconType = self::IMAGE_TYPE_PATH)
    {
        $this->text = $text;
        $this->iconPath = $iconPath;
        $this->iconType = $iconType;
    }

    public function jsonSerialize(): array
    {
        if (!$this->iconPath) return array(
            "text" => $this->text
        );
        else return array(
            "text" => $this->text,
            "image" => array(
                "data" => $this->iconPath,
                "type" => $this->iconType
            )
        );
    }
}