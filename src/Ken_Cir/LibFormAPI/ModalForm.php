<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI;

use JetBrains\PhpStorm\ArrayShape;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class ModalForm extends BaseForm
{
    /**
     * Formのタイトル
     *
     * @var string
     */
    private string $title;

    /**
     * Formの内容
     *
     * @var string
     */
    private string $content;

    /**
     * ボタン1
     *
     * @var string
     */
    private string $button1;

    /**
     * ボタン2
     *
     * @var string
     */
    private string $button2;

    public function __construct(Player $player, string $title, string $content, string $button1, string $button2, callable $responseHandle, ?callable $closeHandler = null)
    {
        parent::__construct($player, $responseHandle, $closeHandler);

        $this->title = $title;
        $this->content = $content;
        $this->button1 = $button1;
        $this->button2 = $button2;

        $player->sendForm($this);
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) $this->close();
        // もしbool型以外の値が返されたら
        elseif (!is_bool($data)) throw new FormValidationException("I expected a response of int but " . gettype($data) . " was returned");
        else $this->response($data);
    }

    #[ArrayShape(["type" => "string", "title" => "string", "content" => "string", "button1" => "string", "button2" => "string"])]
    public function jsonSerialize(): array
    {
        return array(
            "type" => "modal",
            "title" => $this->title,
            "content" => $this->content,
            "button1" => $this->button1,
            "button2" => $this->button2,
        );
    }
}