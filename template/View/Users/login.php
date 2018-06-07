<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 27-04-18
 * Time: 10:50
 */
?>

<h2>Login</h2>
<br>
<form method="POST">
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Log in</button>
        </div>
    </div>
</form>