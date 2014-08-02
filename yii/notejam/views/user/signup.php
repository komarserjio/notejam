<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Sign Up';

?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'offset-by-six sign-in'],
    'fieldConfig' => [
        'template' => "{label}{input}",
    ],
]); ?>

<?= $form->field($model, 'email') ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'email']) ?>

<?= $form->field($model, 'password')->passwordInput() ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'password']) ?>

<?= $form->field($model, 'passwordConfirmation')->passwordInput() ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'passwordConfirmation']) ?>

<?= Html::submitButton('Sign up') ?> or <a href="<?= Url::toRoute('user/signin') ?>">Sign in</a>

<?php ActiveForm::end(); ?>
