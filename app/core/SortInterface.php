<?php

namespace app\core;


interface SortInterface
{
    /**
     * @param string $defaultOrderBy
     * @param int $defaultDirection
     */
    public function __construct(string $defaultOrderBy, int $defaultDirection);

    /**
     * @return string
     */
    public function getOrderBy(): string;

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy);

    /**
     * @param string $orderBy
     * @return bool
     */
    public function isOrderBy(string $orderBy): bool;

    /**
     * @return int
     */
    public function getDirection(): int;

    /**
     * @param int $direction
     */
    public function setDirection(int $direction);

    /**
     * @return array
     */
    public function getSortOptions(): array;

    /**
     * @param string $option
     * @param bool $opposite
     * @return string
     */
    public function getQueryString(string $option, bool $opposite = true): string;
}
