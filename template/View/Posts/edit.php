<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 16-05-18
 * Time: 12:49
 */ ?>

<br>
<form method="POST">
    <fieldset>
        <legend><h2>Edit a post</h2></legend>
        <textarea style="width: 100%" rows="12" name="content" id="content"
                  placeholder="Message"><?= $post->get('content') ?></textarea>
    </fieldset>
    <br>
    <input type="submit" value="Edit" class="btn btn-primary">
</form>
