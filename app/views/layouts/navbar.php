<?php
/**
 * @var \app\core\View $this
 * @var string $content
 */

use app\widgets\LoginButtonWidget;
use app\widgets\CreateButtonWidget;

?>

<?php $this->extend('layouts/main'); ?>

<header>
    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <strong>Test project</strong>
            </a>

            <div class="align-items-right">
                <?php $this->widget(CreateButtonWidget::class) ?>
                <?php $this->widget(LoginButtonWidget::class) ?>
            </div>
        </div>
    </div>
</header>

<?= $content ?>
