<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 13-05-18
 * Time: 18:01
 */
?>

<br>
<form method="POST">
    <fieldset>
        <legend><h2>Editer un topic</h2></legend>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Titre</label>
            <div class="col-sm-10">
                <input type="text" value="<?= $topic->get('name') ?>" name="name" required="required" id="name"
                       class="form-control" placeholder="Titre">
            </div>
        </div>
        <textarea style="width: 100%" rows="12" name="content" id="content"
                  placeholder="Message"><?= $topic->get('content') ?></textarea>
    </fieldset>
    <br>
    <div class="form-group row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </div>
</form>
