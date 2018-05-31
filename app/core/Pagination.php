<?php

namespace app\core;


final class Pagination
{
    /**
     * @var int
     */
    private $itemsTotalCount = 0;
    /**
     * @var int
     */
    private $pageSize;
    /**
     * @var int
     */
    private $currentPage = 1;

    /**
     * @param int $pageSize
     * @param int $total
     * @param int $currentPage
     */
    public function __construct(int $pageSize, int $total, int $currentPage)
    {
        $this->pageSize = $pageSize;
        $this->itemsTotalCount = $total;
        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->pageSize * ($this->currentPage - 1);
    }

    /**
     * @return int
     */
    public function getMaxPageNumber(): int
    {
        return (int)\ceil($this->itemsTotalCount / $this->pageSize);
    }

    /**
     * @return int|null
     */
    public function getNextPage()
    {
        $next = $this->currentPage + 1;
        $max = $this->getMaxPageNumber();

        return $next > $max ? null : $next;
    }

    /**
     * @return int|null
     */
    public function getPreviousPage()
    {
        $prev = $this->currentPage - 1;

        return $prev < 1 ? null : $prev;
    }
}
