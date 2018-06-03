<?php

namespace app\core;


abstract class Sort implements SortInterface
{
    const QUERY_ORDER = 'orderBy';
    const QUERY_DIR = 'dir';

    const SORT_ASC = 1;
    const SORT_DESC = -1;
    const SORT_DEFAULT = 0;

    /**
     * @var string
     */
    private $orderBy;
    /**
     * @var int
     */
    private $direction = self::SORT_DEFAULT;

    /**
     * @param string $defaultOrderBy
     * @param int $defaultDirection
     */
    public function __construct(
        string $defaultOrderBy = null,
        int $defaultDirection = self::SORT_DEFAULT
    ) {
        if ($defaultOrderBy && \in_array($defaultOrderBy, $this->getSortOptions(), true)) {
            $this->setOrderBy($defaultOrderBy);
        }

        $this->setDirection($defaultDirection);
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @param string $orderBy
     * @return bool
     */
    public function isOrderBy(string $orderBy): bool
    {
        return $orderBy === $this->orderBy;
    }

    /**
     * @return int
     */
    public function getDirection(): int
    {
        return $this->direction;
    }

    /**
     * @param int $direction
     */
    public function setDirection(int $direction)
    {
        $this->direction = $direction;
    }

    /**
     * @param string $option
     * @param bool $opposite
     * @return string
     */
    public function getQueryString(string $option, bool $opposite = true): string
    {
        return
            '?' .
            self::QUERY_ORDER . '=' . $option . '&' .
            self::QUERY_DIR . '=' . ($opposite ? $this->getOppositeDirection() : $this->direction);
    }

    /**
     * @return int
     */
    private function getOppositeDirection(): int
    {
        switch ($this->direction) {
            case self::SORT_ASC:
                return self::SORT_DESC;
            case self::SORT_DESC:
                return self::SORT_ASC;
            case self::SORT_DEFAULT:
            default:
                return self::SORT_DESC;
        }
    }
}
