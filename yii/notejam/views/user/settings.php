<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Account Settings';

?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'offset-by-six sign-in'],
    'fieldConfig' => [
        'template' => "{label}{input}",
    ],
]); ?>

<?= $form->field($model, 'currentPassword')->passwordInput(); ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'currentPassword']) ?>

<?= $form->field($model, 'password')->passwordInput(); ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'password']) ?>

<?= $form->field($model, 'passwordConfirmation')->passwordInput() ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'passwordConfirmation']) ?>

<?= Html::submitButton('Save') ?>

<?php ActiveForm::end(); ?>
