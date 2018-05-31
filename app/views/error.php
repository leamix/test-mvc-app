<?php
/**
 * @var \app\core\View $this
 * @var string $message
 * @var array $info
 */
?>

<?php $this->extend('layouts/main'); ?>

<?php $this->addParam('title', $message); ?>

<div class="container mt-5 mb-5">
    <h1><?= $message ?></h1>

    <hr />

    <?php if ($info): ?>

        <pre><?= $info ?></pre>

    <?php endif; ?>
</div>
