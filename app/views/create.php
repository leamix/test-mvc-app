<?php
/**
 * @var \app\core\View $this
 * @var \app\models\Task $task
 */
?>

<?php $this->extend('layouts/navbar'); ?>

<?php $this->addParam('title', 'Create a task'); ?>

<div role="main" class="pb-5">
    <div class="container">
        <div class="py-5 text-left">
            <h2>Create a task</h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form id="mainForm" class="needs-validation" method="post" action="/tasks/create" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="taskUsername">Username</label>
                            <div class="input-group">
                                <input name="username" type="text" class="form-control" id="taskUsername" placeholder="Username" value="<?= $task->username ?>" required>
                                <div class="invalid-feedback" style="width: 100%;">
                                    Your username is required.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="taskEmail">Email</label>
                            <input name="email" type="email" class="form-control" id="taskEmail" placeholder="you@example.com" value="<?= $task->email ?>" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="taskText">Task</label>
                        <textarea name="text" class="form-control" id="taskText" required><?= $task->text ?></textarea>
                        <div class="invalid-feedback">
                            Please enter the task text.
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-group">
                            <label for="taskPicture">Add a picture</label>
                            <input name="picture" type="file" class="form-control-file" id="taskPicture">
                        </div>
                    </div>

                    <hr class="mb-4">

                    <button id="previewBtn" class="btn btn-primary btn-lg btn-block" type="button">Create a task</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Preview</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card mb-12 box-shadow">
                                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="" />
                                        <div class="card-body">
                                            <span class="badge badge-secondary">Created</span>
                                            <p class="card-text" data-source="taskText"></p>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted"><span data-source="taskUsername"></span> | <span data-source="taskEmail"></span></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create a task</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    $(function () {
        $('#previewBtn').on('click', function (event) {
            var $form = $('#mainForm');

            if ($form.get(0).checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                $('[data-source]').each(function (index, element) {
                    var sourceId = $(element).data('source');
                    $(element).text($('#' + sourceId).val());
                });
                $('#exampleModal').modal({show: true});
            }

            $form.addClass('was-validated');
        });
    });
</script>
