<?php

namespace app\core;


final class TaskSort extends Sort
{
    const SORT_BY_USERNAME = 'username';
    const SORT_BY_EMAIL = 'email';
    const SORT_BY_STATUS = 'status';
    const SORT_BY_DATE = 'date';

    /**
     * @return array
     */
    public function getSortOptions(): array
    {
        return [
            self::SORT_BY_USERNAME,
            self::SORT_BY_EMAIL,
            self::SORT_BY_STATUS,
            self::SORT_BY_DATE,
        ];
    }
}
