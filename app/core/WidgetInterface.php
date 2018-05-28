<?php

namespace app\core;

interface WidgetInterface
{
    /**
     * @return string
     */
    public function run(): string;
}
