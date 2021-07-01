<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "{label}{input}",
    ],
]); ?>

<?= $form->field($pad, 'name') ?>
<?= $this->render('/partials/errors', ['model' => $pad, 'field' => 'name']) ?>

<?= Html::submitButton('Save') ?>
<p>
    <a href="<?= Url::toRoute(['pad/delete', 'id' => $pad->id])?>" class="red">Delete pad</a>
</p>

<?php ActiveForm::end(); ?>


