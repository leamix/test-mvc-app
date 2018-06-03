<?php
/**
 * @var \app\core\View $this
 * @var \app\models\Task[] $tasks
 * @var \app\core\Pagination $pagination
 * @var \app\core\TaskSort $sort
 */

use app\widgets\PaginationWidget;
use app\widgets\SingleTaskViewWidget;

?>

<?php $this->extend('layouts/navbar'); ?>

<?php $this->addParam('title', 'Index page'); ?>

<div role="main" class="pb-2">

    <div class="album py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="sort-by list-inline">
                        <li class="list-inline-item">Sort by: </li>
                        <?php foreach ($sort->getSortOptions() as $option): ?>
                        <li class="list-inline-item <?= ($sort->isOrderBy($option) ? 'active' : '') ?>">
                            <a href="<?= $sort->getQueryString($option, $sort->isOrderBy($option)) ?>"><?= $option ?></a>
                            <?php if ($sort->isOrderBy($option)): ?>
                            <span>&nbsp;<?= $sort->getDirection() > 0 ? '&uarr;' : '&darr;' ?></span>
                            <?php else: ?>
                            <span>&nbsp;<?= $sort->getDirection() < 0 ? '&uarr;' : '&darr;' ?></span>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="row">

                <?php foreach ($tasks as $task): ?>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <?php $this->widget(SingleTaskViewWidget::class, [
                            'task' => $task,
                            'showViewBtn' => true,
                        ])?>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
            <div class="row">
                <nav class="col-md-12" aria-label="pagination">
                    <?php $this->widget(PaginationWidget::class, [
                        'pagination' => $pagination,
                        'sort' => $sort,
                    ]) ?>
                </nav>
            </div>
        </div>
    </div>

</div>
