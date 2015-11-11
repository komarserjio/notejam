<?php use yii\helpers\Html; ?>

<?php if ($model->hasErrors($field)): ?>
    <ul class="errorlist">
        <?php foreach ($model->getErrors($field) as $error): ?>
            <li><?= Html::encode($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
