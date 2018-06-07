<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 16-05-18
 * Time: 10:35
 */
?>

<div class="dropdown" style="display: inline-block;margin: 0;padding: 0;">
    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        <?php
        foreach ($links as list($text, $controller, $action, $params, $type)):
            if ($type === 'post') echo $this->Html->postLink($text, ['prefix' => 'admin', 'controller' => $controller, 'action' => $action, 'params' => $params], ['class' => 'dropdown-item', 'unescape' => true]); elseif ($type === 'get') echo $this->Html->link($text, ['prefix' => 'admin', 'controller' => $controller, 'action' => $action, 'params' => $params], ['class' => 'dropdown-item', 'unescape' => true]);
        endforeach;
        ?>
    </div>
</div>
