<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-04-18
 * Time: 11:15
 */
?>

<table class="table">
    <?php foreach ($forums as $forum): ?>
        <thead class="thead-dark">
            <tr>
                <th colspan="2">
                    <?= $forum->get('name') ?>
                </th>
                <?php
                if (isset($_SESSION['user'])) if ($_SESSION['user']->get('role') === 'admin') {
                    echo "<th colspan='1'>" . $this->loadBlock('admin_dropdown', ['links' => [["Delete", "forums", "delete", [$forum->get('id')], 'post'], ["Edit", "forums", "edit", [$forum->get('id')], 'get'], ["Create category", "categories", "add", [$forum->get('id')], 'get']]]) . "</th>";
                }
                ?>
            </tr>
        </thead>

        <tbody>

        <?php
        if (empty($forum->categories))
        {
            echo "<td colspan='2'>No category :(</td>";
            continue;
        }

        foreach ($forum->categories as $category): ?>
            <tr>
                <td>
                    <?= $this->Html->link($category->get('name'),
                        ['controller' => 'topics', 'action' => 'index',
                            'params' => [$category->get('id')]
                        ]
                    ) ?>
                </td>
                <?php
                if (isset($_SESSION['user'])) if ($_SESSION['user']->get('role') === 'admin') {
                    echo "<td colspan='2'>" . $this->loadBlock('admin_dropdown', ['links' => [["Delete", "categories", "delete", [$category->get('id')], 'post'], ["Edit", "categories", "edit", [$category->get('id')], 'get']]]) . "</td>";
                }
                ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php endforeach; ?>
</table>

<?php
if (isset($_SESSION['user'])) if ($_SESSION['user']->get('role') === 'admin') echo $this->Html->link('Create forum', ['prefix' => 'admin', 'action' => 'add','params' => [0]], ['class' => 'btn btn-primary'])
?>

