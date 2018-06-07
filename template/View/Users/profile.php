<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 03-05-18
 * Time: 21:36
 */
?>

<h2>Your profile</h2>
<hr>
<div class="row">
    <div class="col-md-3">
        <i class="fa fa-user-circle fa-8x"></i>
    </div>
    <div class="col-md-9">
        <form method="post">
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Names</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?= $_SESSION['user']->get('firstname') ?>"
                           id="firstname" name="firstname" placeholder="firstname">
                    <input type="text" class="form-control" value="<?= $_SESSION['user']->get('name') ?>"
                           id="name" name="name" placeholder="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" disabled class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <p><?= $_SESSION['user']->get('email') ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="username" disabled class="col-sm-2">Joined</label>
                <div class="col-sm-10">
                    <p><?= $_SESSION['user']->get('creation') ?></p>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Edit">
            <!-- Button to Open the Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal">
                Change password
            </button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">
                Delete my account
            </button>
        </form>
    </div>
</div>

<!-- Change password modal -->
<div class="modal" id="changePasswordModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" id="change_password"
                      action=<?= \Framework\Helpers\UrlBuilder::build(['controller' => 'users', 'action' => 'changePassword']) ?>>
                    <div class="form-group row">
                        <label for="password_old" class="col-sm-4">Old Password</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value=""
                                   id="password_old" name="password_old" placeholder="Old Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-4">New Password</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value=""
                                   id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" form="change_password" class="btn btn-danger" value="Change your password">
            </div>
        </div>
    </div>
</div>

<!-- Confirm modal -->
<div class="modal" id="confirmDeleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm account deletion</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" id="delete_account"
                      action=<?= \Framework\Helpers\UrlBuilder::build(['controller' => 'users', 'action' => 'delete']) ?>>
                    <div class="form-group row">
                        <label for="password" class="col-sm-4">Password</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value=""
                                   id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" form="delete_account" class="btn btn-danger" value="Delete my account">
            </div>
        </div>
    </div>
</div>