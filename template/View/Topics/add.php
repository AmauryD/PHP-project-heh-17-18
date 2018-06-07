<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 13-05-18
 * Time: 17:08
 */
?>

<br>
<form method="POST">
    <fieldset>
        <legend><h2>Ajouter un topic</h2></legend>
        <div class="input-group">
            <input type="text" name="name" id="name" class="form-control" placeholder="Titre">
        </div>
        <br>
        <div class="input-group">
            <textarea style="width: 100%" rows="12" name="content" id="content" placeholder="Message"></textarea>
        </div>
        <div class="form-group">
            <label for="datetimepicker">Expiration</label>
            <div class='input-group date' id='datetimepicker'>
                <input type='date' name="date" class="form-control" min="<?= date('Y-m-d', time()); ?>"/>
                <input type='time' name="time" class="form-control"/>
            </div>
        </div>
    </fieldset>
    <br>
    <input type="submit" value="Add" class="btn btn-primary">
</form>