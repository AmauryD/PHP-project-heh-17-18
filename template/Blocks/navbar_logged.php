<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 19-04-18
 * Time: 10:01
 */
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <?= $this->Html->link('Home', ['controller' => 'forums', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link('Members', ['controller' => 'users', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
        </ul>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <span>Logged as <strong><?= $_SESSION['user']->get('firstname') ?></strong></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?= $this->Html->link('<i class="fa fa-user"></i>&nbsp;Profile', ['controller' => 'users', 'action' => 'profile'], ['class' => 'dropdown-item', 'unescape' => true]) ?>
                    <?= $this->Html->link('<i class="fa fa-sign-out-alt"></i>&nbsp;Logout', ['controller' => 'users', 'action' => 'logout'], ['class' => 'dropdown-item', 'unescape' => true]) ?>
                </div>
            </li>
        </ul>
    </div>
</nav>