<?php
/**
 * @var \app\core\View $this
 * @var \app\models\Task[] $tasks
 * @var \app\core\Pagination $pagination
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
                    ]) ?>
                </nav>
            </div>
        </div>
    </div>

</div>
