<?php
/**
 * @var \app\core\View $this
 * @var Task $task
 */

use app\models\Task;

?>

<?php $this->extend('layouts/navbar'); ?>

<?php $this->addParam('title', 'Update a task'); ?>

<div role="main" class="pb-5">
    <div class="container">
        <div class="py-5 text-left">
            <h2>Update a task</h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form class="needs-validation" method="post" action="/tasks/update/<?= $task->id ?>" novalidate>
                    <div class="mb-3">
                        <label for="tasktext">Task</label>
                        <textarea name="text" class="form-control" id="tasktext" required><?= $task->text ?></textarea>
                        <div class="invalid-feedback">
                            Please enter the task text.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="state">Status</label>
                        <select class="custom-select d-block w-100" id="status" required>
                            <option <?= ($task->status === Task::STATUS_CREATED ? 'selected' : '') ?> value="<?= Task::STATUS_CREATED ?>">Created</option>
                            <option <?= ($task->status === Task::STATUS_IN_PROGRESS ? 'selected' : '') ?> value="<?= Task::STATUS_IN_PROGRESS ?>">In process</option>
                            <option <?= ($task->status === Task::STATUS_DONE ? 'selected' : '') ?> value="<?= Task::STATUS_DONE ?>">Done</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid status.
                        </div>
                    </div>

                    <hr class="mb-4">

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Save changes</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
   (function () {
       'use strict';

       window.addEventListener('load', function () {
           // Fetch all the forms we want to apply custom Bootstrap validation styles to
           var forms = document.getElementsByClassName('needs-validation');

           // Loop over them and prevent submission
           var validation = Array.prototype.filter.call(forms, function (form) {
               form.addEventListener('submit', function (event) {
                   if (form.checkValidity() === false) {
                       event.preventDefault();
                       event.stopPropagation();
                   }
                   form.classList.add('was-validated');
               }, false);
           });
       }, false);
   })();
</script>
