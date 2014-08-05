<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Forgot Password?';
?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'offset-by-six sign-in'],
    'fieldConfig' => [
        'template' => "{label}{input}",
    ],
]); ?>

<?= $form->field($model, 'email'); ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'email']) ?>

<?= Html::submitButton('Generate password') ?>

<?php ActiveForm::end(); ?>

