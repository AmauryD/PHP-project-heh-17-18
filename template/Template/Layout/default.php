<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 20-02-18
 * Time: 10:41
 */
?>

<html>
    <head>
        <title><?= $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?= $this->Html->js('jquery-3.2.1.slim.min.js') ?>
        <?= $this->Html->js('popper.min.js') ?>
        <?= $this->Html->js('bootstrap.min.js') ?>
        <?= $this->Html->css("bootstrap.min.css") ?>
        <?= $this->Html->css("style.css") ?>
        <?= $this->Html->css("fontawesome-all.css") ?>
    </head>
    <body>
    <?= empty($_SESSION['user']) ? $this->loadBlock('navbar') : $this->loadBlock('navbar_logged') ?>
    <div class="container">
        <div class="row">
            <div class="col col-md-12" style="margin: 1vh">
                <?php $this->Flash->render() ?>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-8">
                <?= $this->getBlock('content') ?>
            </div>
            <div class="col col-md-4">
                <?= $this->loadBlock('sidebar') ?>
            </div>
        </div>
    </div>
    <?= $this->loadBlock('footer') ?>
    </body>
</html>
