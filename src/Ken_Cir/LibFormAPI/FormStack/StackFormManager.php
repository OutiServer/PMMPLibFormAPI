<?php

declare(strict_types=1);

namespace Ken_Cir\LibFormAPI\FormStack;

use Ken_Cir\LibFormAPI\Forms\CustomForm;
use Ken_Cir\LibFormAPI\Forms\ModalForm;
use Ken_Cir\LibFormAPI\Forms\SimpleForm;
use pocketmine\utils\SingletonTrait;

class StackFormManager
{
    use SingletonTrait;

    /**
     * @var StackForm[]
     */
    private array $stacks;

    public function __construct()
    {
        self::setInstance($this);

        $this->stacks = [];
    }

    /**
     * Stackを取得する
     *
     * @param string $xuid
     * @return CustomForm[]|ModalForm[]|SimpleForm[]|null
     */
    public function getStack(string $xuid): ?array
    {
        if (!isset($this->stacks[$xuid])) return null;

        return $this->stacks[$xuid];
    }

    /**
     * Stack内のFormを取得する
     *
     * @param string $xuid
     * @param string $key
     * @return CustomForm|ModalForm|SimpleForm|null
     */
    public function getStackForm(string $xuid, string $key): CustomForm|ModalForm|SimpleForm|null
    {
        if (!$this->getStack($xuid)) return null;
        elseif (!isset($this->stacks[$xuid][$key])) return null;

        return $this->stacks[$xuid][$key];
    }

    public function getStackFormEnd(string $xuid): CustomForm|ModalForm|SimpleForm|null
    {
        if (!$this->getStack($xuid)) return null;

        return $this->getStackForm($xuid, array_key_last($this->getStack($xuid)));
    }

    /**
     * Stackを追加する
     *
     * @param string $xuid
     * @param string $key
     * @param CustomForm|ModalForm|SimpleForm $form
     * @return void
     */
    public function addStackForm(string $xuid, string $key, CustomForm|ModalForm|SimpleForm $form): void
    {
        if ($this->getStack($xuid)) $this->stacks[$xuid][$key] = $form;
        else {
            $this->stacks[$xuid] = [];
            $this->stacks[$xuid][$key] = $form;
        }
    }

    /**
     * StackからFormを削除する
     * @param string $xuid
     * @param string $key
     * @return void
     */
    public function deleteStackForm(string $xuid, string $key): void
    {
        // 念の為
        if (!$this->getStack($xuid)) return;;
        unset($this->stacks[$xuid][$key]);
    }

    /**
     * Stackを削除する(というかクリアする)
     *
     * @param string $xuid
     * @return void
     */
    public function deleteStack(string $xuid): void
    {
        unset($this->stacks[$xuid]);
    }
}