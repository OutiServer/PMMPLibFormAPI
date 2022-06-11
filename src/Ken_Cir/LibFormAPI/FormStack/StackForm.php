<?php

namespace Ken_Cir\LibFormAPI\FormStack;

use Ken_Cir\LibFormAPI\Forms\CustomForm;
use Ken_Cir\LibFormAPI\Forms\ModalForm;
use Ken_Cir\LibFormAPI\Forms\SimpleForm;

class StackForm
{
    /**
     * @var CustomForm[]|ModalForm[]|SimpleForm[]
     */
    private array $forms;

    public function __construct()
    {
        $this->forms = [];
    }

    public function getAll(): array
    {
        return $this->forms;
    }

    public function get(string $key): CustomForm|ModalForm|SimpleForm|null
    {
        if (!isset($this->forms[$key])) return null;

        return $this->forms[$key];
    }

    /**
     * stackの最後のFormを取得する
     *
     * @return CustomForm|ModalForm|SimpleForm|null
     */
    public function getEnd(): CustomForm|ModalForm|SimpleForm|null
    {
        return $this->get(array_key_last($this->forms));
    }

    /**
     * stackに追加する
     *
     * @param string $key
     * @param CustomForm|ModalForm|SimpleForm $form
     * @return void
     */
    public function add(string $key, CustomForm|ModalForm|SimpleForm $form): void
    {
        $this->forms[$key] = $form;
    }

    public function delete(string $key): void
    {
        unset($this->forms[$key]);
    }
}