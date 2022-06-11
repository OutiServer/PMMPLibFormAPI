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
     * 未Encodeのcontent
     *
     * @var array
     */
    private array $rawContent;

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
        $this->rawContent = $contents;
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

    public function reSend(): void
    {
        if (!$this->responded) {
            $this->getPlayer()->sendForm($this);
            return;
        }

        foreach ($this->rawContent as $key => $content) {
            if ($content instanceof ContentDropdown) {
                $this->rawContent[$key] = new ContentDropdown($content->getText(), $content->getOptions(), $this->responseData[$key]);
            }
            elseif ($content instanceof ContentInput) {
                $this->rawContent[$key] = new ContentInput($content->getText(), $content->getPlaceholder(), $this->responseData[$key]);
            }
            elseif ($content instanceof ContentLabel) {
                $this->rawContent[$key] = $content;
            }
            elseif ($content instanceof ContentSlider) {
                $this->rawContent[$key] = new ContentSlider($content->getText(), $content->getMin(), $content->getMax(), $content->getStep(), $this->responseData[$key]);
            }
            elseif ($content instanceof ContentStepSlider) {
                $this->rawContent[$key] = new ContentStepSlider($content->getText(), $content->getSteps(), $this->responseData[$key]);
            }
            elseif ($content instanceof ContentToggle) {
                $this->rawContent[$key] = new ContentToggle($content->getText(), $this->responseData[$key]);
            }
            else throw new InvalidArgumentException("Unknown content class " . get_class($content));

            $this->content[$key] = json_decode(json_encode( $this->rawContent[$key]), true);
        }

        $this->getPlayer()->sendForm($this);
    }
}