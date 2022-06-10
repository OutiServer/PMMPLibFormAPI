<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormContents\CustomForm;

use JsonSerializable;

abstract class BaseContent implements JsonSerializable
{
    /**
     * 内容のテキスト(説明など)
     *
     * @var string
     */
    protected string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }
}