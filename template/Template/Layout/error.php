<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 13-05-18
 * Time: 11:23
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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron" style="padding-bottom: 1vh">
                <h1><?= $title ?></h1>
                <p><?= $message ?></p>
                <?= $this->Html->link("<i class='fa fa-home'></i>&nbsp;Return Home", ['action' => 'index','controller' => 'forums'], ['unescape' => true, 'class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?= $this->loadBlock('footer') ?>
</body>
</html>
