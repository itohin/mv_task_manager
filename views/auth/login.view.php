<?php
    $errors = isset($_SESSION["errors"]) ? $_SESSION["errors"] : null;
    $old = isset($_SESSION["old"]) ? $_SESSION["old"] : null;
    $denied = $errors && isset($_SESSION["errors"]["denied"]);
    flushFlashes();
?>

<?php if ($denied) : ?>
    <div class="container">
        <div class="alert alert-danger text-center" role="alert">
            Incorrect username or password
        </div>
    </div>
<?php endif ?>

<div class="container d-flex justify-content-center">

    <div class="card w-50 mt-3">
        <div class="card-header text-center">
            Sign Up
        </div>
        <div class="card-body">
            <form action="login" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="login" value="<?= $old && isset($old['login']) ? $old['login'] : '' ?>">
                    <?php
                        if ($errors && isset($errors['login'])) :
                            foreach ($errors['login'] as $error) :
                                ?>
                                <small class="form-text text-muted"><?= $error ?></small>
                                <br>
                            <?php
                            endforeach;
                        endif;
                    ?>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" value="<?= $old && isset($old['password']) ? $old['password'] : '' ?>">
                    <?php
                        if ($errors && isset($errors['password'])) :
                            foreach ($errors['password'] as $error) :
                                ?>
                                <small class="form-text text-muted"><?= $error ?></small>
                                <br>
                            <?php
                            endforeach;
                        endif;
                    ?>
                </div>
                <div class="form-group text-center mt-5">
                    <button class="btn btn-primary w-100">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</div>
