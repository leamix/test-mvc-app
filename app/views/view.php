<?php
/**
 * @var \app\core\View $this
 * @var \app\models\Task $task
 */

use app\widgets\SingleTaskViewWidget;

?>

<?php $this->extend('layouts/navbar'); ?>

<?php $this->addParam('title', 'View page'); ?>

<div role="main" class="pb-5">

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-12 box-shadow">
                        <?php $this->widget(SingleTaskViewWidget::class, [
                            'task' => $task,
                            'showViewBtn' => false,
                        ])?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
