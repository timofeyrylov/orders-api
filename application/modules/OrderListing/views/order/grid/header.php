<?php
/** @var $columns */
?>

<thead>
<tr>
    <?php foreach ($columns as $column): ?>
    <th class="<?= $column[1] ?? null ?>"><?= $column[0] ?></th>
    <?php endforeach; ?>
</thead>