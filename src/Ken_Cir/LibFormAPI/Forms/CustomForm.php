<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\Forms;

use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use Ken_Cir\LibFormAPI\FormContents\CustomForm\BaseContent;
use Ken_Cir\LibFormAPI\FormContents\CustomForm\ContentDropdown;
use Ken_Cir\LibFormAPI\FormContents\CustomForm\ContentInput;
use Ken_Cir\LibFormAPI\FormContents\CustomForm\ContentLabel;
use Ken_Cir\LibFormAPI\FormContents\CustomForm\ContentSlider;
use Ken_Cir\LibFormAPI\FormContents\CustomForm\ContentStepSlider;
use Ken_Cir\LibFormAPI\FormContents\CustomForm\ContentToggle;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class CustomForm extends BaseForm
{
    /**
     * Formタイトル
     *
     * @var string
     */
    private string $title;

    /**
     * Formの中身配列
     *
     * @var array
     */
    private array $content;

    /**
     * @param Player $player
     * @param string $title
     * @param ContentLabel[]|ContentToggle[]|ContentDropdown[]|ContentInput[]|ContentSlider[]|ContentStepSlider[] $contents
     * @param callable $responseHandle
     * @param callable|null $closeHandler
     */
    public function __construct(Player $player, string $title, array $contents, callable $responseHandle, callable $closeHandler = null)
    {
        parent::__construct($player, $responseHandle, $closeHandler);

        $this->title = $title;
        foreach ($contents as $content) {
            if (!$content instanceof ContentDropdown
                and !$content instanceof ContentInput
                and !$content instanceof ContentLabel
                and !$content instanceof ContentSlider
                and !$content instanceof ContentStepSlider
                and !$content instanceof ContentToggle) throw new InvalidArgumentException("Illegal class " . get_class($content));

            $this->content[] = json_decode(json_encode($content), true);
        }

        $player->sendForm($this);
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) $this->close();
        // 配列以外が返された
        elseif (!is_array($data)) throw new FormValidationException("I expected a response of array but " . gettype($data) . " was returned");
        // 配列内の量が一致しない
        elseif (count($data) !== count($this->content)) throw new FormValidationException("Array quantities do not match");
        else $this->response($data);
    }

    #[ArrayShape(["type" => "string", "title" => "string", "content" => "array"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "custom_form",
            "title" => $this->title,
            "content" => $this->content
        );
    }
}