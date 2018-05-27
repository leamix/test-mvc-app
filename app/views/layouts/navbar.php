<?php
/**
 * @var \src\View $this
 * @var string $content
 */

use app\widgets\LoginButtonWidget;

?>

<?php $this->extend('layouts/main'); ?>

<header>
    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <strong>Test project</strong>
            </a>

            <div class="align-items-right">
                <a href="/tasks/create" class="btn btn-primary my-2">Create an article</a>
                <?= $this->widget(LoginButtonWidget::class) ?>
            </div>
        </div>
    </div>
</header>

<?= $content ?>
