<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 19-04-18
 * Time: 10:01
 */
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">My Forum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <?= $this->Html->link('Home', ['controller' => 'forums', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link('Members', ['controller' => 'users', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav mr-auto">
        <?= $this->Html->link('Log in', ['controller' => 'users', 'action' => 'login'], ['class' => 'nav-link']) ?>
    </ul>
    <ul class="navbar-nav mr-auto">
        <?= $this->Html->link('Sign in', ['controller' => 'users', 'action' => 'add'], ['class' => 'nav-link']) ?>
    </ul>
</nav>
