<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 16-05-18
 * Time: 10:35
 */
?>

<div class="dropdown" style="display: inline-block">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        <?php
        foreach ($links as list($text, $controller, $action, $params)):
            echo $this->Html->link($text, ['controller' => $controller, 'action' => $action, 'params' => $params], ['class' => 'dropdown-item', 'unescape' => true]);
        endforeach;
        ?>
    </div>
</div>
