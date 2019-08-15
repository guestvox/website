<?php

defined('_EXEC') or die;

class Placeholders_vkye
{
    private $buffer;
    private $format;

    public function __construct($buffer)
    {
        $this->format = new Format();
        $this->buffer = $buffer;
    }

    public function run()
    {
        $this->buffer = $this->main_menu();

        return $this->buffer;
    }

    private function main_menu()
    {
        return $this->format->include_file($this->buffer, 'header');
    }
}
