<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 12-05-18
 * Time: 13:12
 */
?>

<table class="table table-bordered table-topic">
    <tbody>
    <tr>
        <td colspan="1">
            <?php
            if ($topic->get('user_id') === $_SESSION['user']->get('id')) {
                echo $this->loadBlock('user_dropdown', ['links' => [["Edit", "topics", "edit", [$topic->get('id')],'get']]]);
            }
            if ($_SESSION['user']->get('role') === 'admin') {
                echo $this->loadBlock('admin_dropdown', ['links' => [["Delete", "topics", "delete", [$topic->get('id')],'post']]]);
            }
            ?>
        </td>
        <td colspan="4" style="font-size: 25px">&nbsp;<b><?= $topic->get('name') ?></b></td>
    </tr>
    <tr>
        <td class="text-center">
            <p>
                <?= $topic->users[0]->get('firstname') ?>
            </p>
            <i class="fa fa-user fa-4x"></i>
        </td>
        <td colspan="4">
            <p>
                <?= $topic->get('content'); ?>
            </p>
        </td>
    </tr>

    <?php
    /** @var \Framework\Model\Entity[] $posts */
    foreach ($posts as $post) :
        $autor = $post->users[0];
        ?>

        <tr>
            <td colspan="1">
                <?php
                if ($autor->get('id') === $_SESSION['user']->get('id')) {
                    echo $this->loadBlock('user_dropdown', ['links' => [
                            ["Edit", "posts", "edit", [$post->get('id')]]
                    ]]);
                }
                if ($_SESSION['user']->get('role') === 'admin') {
                    echo $this->loadBlock('admin_dropdown', ['links' =>
                        [
                                ["Delete", "posts", "delete", [$post->get('id')],'post'],
                            ["Edit", "posts", "edit", [$post->get('id')],'post']
                        ],
                    ]);
                }
                ?>
            </td>
            <td colspan="4"></td>
        </tr>
        <td colspan="1" class="text-center">
            <p>
                <?= $autor->get('firstname') ?>
            </p>
            <i class="fa fa-user fa-4x"></i>
        </td>
        <td colspan="4">
            <p>
                <?= $post->get('content'); ?>
            </p>
        </td>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Html->link('Add a post', ['controller' => 'posts', 'action' => 'add', 'params' => [$topic->get('id')]], ['class' => "btn btn-primary"]) ?>

