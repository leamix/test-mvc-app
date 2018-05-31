<?php
/**
 * @var \app\core\View $this
 * @var \app\models\Task[] $tasks
 * @var int $page
 */
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
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text"><?= $task->text ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-secondary" href="/tasks/<?= $task->id ?>">View</a>
                                    <a class="btn btn-sm btn-outline-secondary" href="/tasks/update/<?= $task->id ?>">Edit</a>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

</div>
