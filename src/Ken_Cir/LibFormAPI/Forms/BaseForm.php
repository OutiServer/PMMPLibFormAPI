<?php

namespace Ken_Cir\LibFormAPI\Forms;

use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class BaseForm implements Form
{
    /**
     * レスポンスが何か返されたか
     *
     * @var bool
     */
    public bool $responded;

    /**
     * フォームが閉じられたか
     *
     * @var bool
     */
    public bool $closed;

    private Player $player;

    /**
     * フォームから正常にレスポンスされた時に呼び出す関数
     *
     * @var callable
     */
    protected $responseHandle;

    /**
     * フォームが閉じられた時に呼び出す関数(正常にレスポンスされた時は呼び出されません)
     *
     * @var callable|null
     */
    protected $closeHandler;

    public function __construct(Player $player, callable $responseHandle, callable $closeHandler = null)
    {
        $this->responded = false;
        $this->closed = false;
        $this->player = $player;
        $this->responseHandle = $responseHandle;
        $this->closeHandler = $closeHandler;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * Formが閉じられた時に呼び出す関数
     *
     * @return void
     */
    protected function close(): void
    {
        if ($this->closeHandler) ($this->closeHandler)($this->player);
        $this->closed = true;
    }

    /**
     * 正常にレスポンスが返された時に呼び出す関数
     *
     * @param $data
     * @return void
     */
    protected function response(&$data): void
    {
        ($this->responseHandle)($this->player, $data);
        $this->responded = true;
    }
}