<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 22-05-18
 * Time: 08:58
 */
?>

<h2>Edit a forum</h2>
<hr>
<form method="POST">
    <fieldset>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name : </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="<?= $forum->get('name') ?>" id="name" name="name" placeholder="Name">
            </div>
        </div>
    </fieldset>
    <div class="form-group row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </div>
</form>

