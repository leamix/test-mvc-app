<?php

namespace app\core;


use Psr\Http\Message\ServerRequestInterface;

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
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(int $pageSize, ServerRequestInterface $request)
    {
        $this->pageSize = $pageSize;
        $this->request = $request;
    }

    /**
     * @param int $total
     */
    public function setItemsTotal(int $total)
    {
        $this->itemsTotalCount = $total;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->request->getAttribute('page', 1);
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
        $pageSize = $this->getPageSize();
        $page = $this->getCurrentPage();

        return $pageSize * ($page - 1);
    }
}
