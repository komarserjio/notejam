<?php if ($model->hasErrors($field)): ?>
    <ul class="errorlist">
        <?php foreach ($model->getErrors($field) as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
