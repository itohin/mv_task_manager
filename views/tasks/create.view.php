<?php
$errors = isset($_SESSION["errors"]) ? $_SESSION["errors"] : null;
$old = isset($_SESSION["old"]) ? $_SESSION["old"] : null;
?>

<div class="container d-flex justify-content-center">

    <div class="card w-75 mt-3">
        <div class="card-header text-center">
            Create Task
        </div>
        <div class="card-body">
            <form action="/tasks" method="POST">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="<?= $old && isset($old['name']) ? $old['name'] : '' ?>">
                    <?php
                    if ($errors && isset($errors['name'])) :
                        foreach ($errors['name'] as $error) :
                            ?>
                            <small class="form-text text-muted"><?= $error ?></small>
                            <br>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="<?= $old && isset($old['email']) ? $old['email'] : '' ?>">
                    <?php
                    if ($errors && isset($errors['email'])) :
                        foreach ($errors['email'] as $error) :
                            ?>
                            <small class="form-text text-muted"><?= $error ?></small>
                            <br>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                <div class="form-group">
                    <label>Task content</label>
                    <textarea class="form-control" name="content" rows="5"><?= $old && isset($old['content']) ? $old['content'] : '' ?></textarea>
                    <?php
                    if ($errors && isset($errors['content'])) :
                        foreach ($errors['content'] as $error) :
                            ?>
                            <small class="form-text text-muted"><?= $error ?></small>
                            <br>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary w-100">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>