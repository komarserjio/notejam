<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Sign Up';

?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'offset-by-six sign-in'],
    'fieldConfig' => [
        'template' => "{label}{input}{error}",
    ],
]); ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'passwordConfirmation')->passwordInput() ?>

<?= Html::submitButton('Sign Up') ?>

<?php ActiveForm::end(); ?>
