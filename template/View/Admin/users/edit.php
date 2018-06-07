<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 22-05-18
 * Time: 19:34
 */
?>

<h2>Editer l'utilisateur <?= $user->get('firstname') ?></h2>
<br>
<form method="post">
    <div class="form-group row">
        <label for="firstname" class="col-sm-2 col-form-label">Firstname</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" value="<?= $user->get('firstname') ?>" id="firstname"
                   name="firstname" placeholder="firstname">
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" value="<?= $user->get('name') ?>" id="name" name="name"
                   placeholder="name">
        </div>
    </div>
    <div class="form-group row">
        <label for="role" class="col-sm-2 col-form-label">Role</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" value="<?= $user->get('role') ?>" id="role" name="role"
                   placeholder="role">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </div>
</form>
