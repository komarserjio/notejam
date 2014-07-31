<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Sign In';

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

<?= Html::submitButton('Sign In') ?>

<?php ActiveForm::end(); ?>
