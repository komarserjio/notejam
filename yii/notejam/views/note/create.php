<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Pad;
$this->title = 'New note';

?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'note'],
    'fieldConfig' => [
        'template' => "{label}{input}",
    ],
]); ?>

<?= $form->field($model, 'name') ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'name']) ?>

<?= $form->field($model, 'text')->textArea() ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'text']) ?>

<?= $form->field($model, 'pad_id')->dropDownList(ArrayHelper::map(Yii::$app->user->identity->pads, 'id', 'name')); ?>
<?= $this->render('/partials/errors', ['model' => $model, 'field' => 'pad_id']) ?>

<?= Html::submitButton('Save') ?>

<?php ActiveForm::end(); ?>

