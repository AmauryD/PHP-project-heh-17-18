<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 07-05-18
 * Time: 11:15
 */
?>


<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col" colspan="2">
            Nom du topic
        </th>
        <th scope="col">Posts</th>
        <th scope="col">Auteur</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($topics as $topic): ?>
        <tr>
            <td colspan="2">
                <?= $this->Html->link($topic->get('name'), ['action' => 'view', 'params' => [$topic->get('id')]]) ?>
            </td>
            <td><?= count($topic->posts) ?></td>
            <td><?= $topic->users[0]->get('firstname') ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Html->link('Ajouter un topic', ['action' => 'add', 'params' => [$forum_id]], ['class' => "btn btn-primary"]) ?>

