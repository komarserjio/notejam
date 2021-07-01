<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Sign In';

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

<?= Html::submitButton('Sign in') ?> or <a href="<?= Url::toRoute('user/signup') ?>">Sign up</a>
<hr />
<a href="<?= Url::toRoute('user/forgot-password') ?>" class="small-red">Forgot password?</a>

<?php ActiveForm::end(); ?>
