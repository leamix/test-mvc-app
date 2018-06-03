<?php
/**
 * @var \app\models\Task $task
 * @var bool $showViewBtn
 * @var bool $showEditBtn
 */

switch ($task->status) {
    case \app\models\Task::STATUS_DONE:
        $statusClass = 'badge-success';
        break;

    case \app\models\Task::STATUS_IN_PROGRESS:
        $statusClass = 'badge-info';
        break;

    case \app\models\Task::STATUS_CREATED:
    default:
        $statusClass = 'badge-secondary';
        break;
}
?>

<img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap" />
<div class="card-body">
    <span class="badge <?= $statusClass ?>"><?= $task->status ?></span>
    <p class="card-text"><?= $task->text ?></p>
    <div class="d-flex justify-content-between">
        <div class="btn-group">
            <?php if ($showViewBtn): ?>
            <a class="btn btn-sm btn-outline-secondary" href="/tasks/view/<?= $task->id ?>">View</a>
            <?php endif; ?>
            <?php if ($showEditBtn): ?>
            <a class="btn btn-sm btn-outline-secondary" href="/tasks/update/<?= $task->id ?>">Edit</a>
            <?php endif; ?>
        </div>
        <small class="text-muted"><?= $task->username ?> | <?= $task->email ?></small>
    </div>
</div>
