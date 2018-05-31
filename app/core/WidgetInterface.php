<?php

namespace app\core;

interface WidgetInterface
{
    /**
     * @param array $params
     * @return string
     */
    public function run(array $params = []): string;
}
