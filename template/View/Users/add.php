<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 27-04-18
 * Time: 11:13
 */
?>

<h2>Inscription</h2>
<br>
<form method="POST">
    <div class="form-group row">
        <label for="firstname" class="col-sm-2 col-form-label">Nom</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="firstname">
            <input type="text" class="form-control" id="name" name="name" placeholder="name">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group row">
        <label for="password_confirm" class="col-sm-2 col-form-label">Confirmation</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                   placeholder="Password Confirm">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
    </div>
</form>
