<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $model->name;

?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "{label}{input}",
    ],
]); ?>

<?= $form->field($model, 'name') ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'name']) ?>

<?= Html::submitButton('Save') ?>

<?php ActiveForm::end(); ?>

