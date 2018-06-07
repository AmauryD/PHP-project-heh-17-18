<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 24-04-18
 * Time: 15:09
 */
?>

<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Inscription</th>
        <?php
        if (isset($_SESSION['user'])) if ($_SESSION['user']->get('role') === 'admin') {
            echo "<th></th>";
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->get('firstname') ?></td>
            <td><?= $user->get('email') ?></td>
            <td><?= $user->get('creation') ?></td>
            <?php
            if (isset($_SESSION['user'])) if ($_SESSION['user']->get('role') === 'admin') {
                echo "<th>" . $this->loadBlock('admin_dropdown', ['links' => [["Delete", "users", "delete", [$user->get('id')], 'post'], ["Edit", "users", "edit", [$user->get('id')], 'get']]]) . "</th>";
            }
            ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
