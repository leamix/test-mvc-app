<?php

namespace app\widgets;


use app\core\WidgetInterface;

final class PaginationWidget implements WidgetInterface
{
    /**
     * @inheritdoc
     */
    public function run(array $params = []): string
    {
        \extract($params, EXTR_OVERWRITE);

        return require APP_DIR . '/app/views/parts/pagination.php';
    }
}
