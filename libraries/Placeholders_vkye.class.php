<?php

defined('_EXEC') or die;

class Placeholders_vkye
{
    private $buffer;
    private $format;

    public function __construct($buffer)
    {
        $this->buffer = $buffer;
        $this->format = new Format();
    }

    public function run()
    {
        $this->buffer = $this->replace_header();
        $this->buffer = $this->replace_placeholders();

        return $this->buffer;
    }

    private function replace_header()
    {
        return $this->format->include_file($this->buffer, 'header');
    }

    private function replace_placeholders()
    {
        $replace = [
            '{$seo_keywords}' => '',
            '{$seo_description}' => ''
        ];

        return $this->format->replace($replace, $this->buffer);
    }
}
