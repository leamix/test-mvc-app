<?php
/**
 * @var \app\core\Pagination $pagination
 */

$currentPage = $pagination->getCurrentPage();
$prevPage = $pagination->getPreviousPage();
$nextPage = $pagination->getNextPage();
?>

<ul class="pagination justify-content-center">
    <?php if ($prevPage): ?>
    <li class="page-item">
        <a class="page-link" href="/page/<?= $prevPage ?>" tabindex="-1">Previous</a>
    </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $pagination->getMaxPageNumber(); $i++): ?>
    <li class="page-item <?= ($i === $currentPage ? 'active' : '') ?>">
        <a href="/page/<?= $i ?>" class="page-link"><?= $i ?></a>
    </li>
    <?php endfor; ?>

    <?php if ($nextPage): ?>
    <li class="page-item">
        <a class="page-link" href="/page/<?= $nextPage ?>">Next</a>
    </li>
    <?php endif; ?>
</ul>
