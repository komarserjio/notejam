<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Pad;
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'note'],
    'fieldConfig' => [
        'template' => "{label}{input}",
    ],
]); ?>

<?= $form->field($note, 'name') ?>
<?= $this->render('/partials/errors', ['model' => $note, 'field' => 'name']) ?>

<?= $form->field($note, 'text')->textArea() ?>
<?= $this->render('/partials/errors', ['model' => $note, 'field' => 'text']) ?>

<?= $form->field($note, 'pad_id')->dropDownList(ArrayHelper::map(Yii::$app->user->identity->pads, 'id', 'name'), ['prompt' => '-----------']); ?>
<?= $this->render('/partials/errors', ['model' => $note, 'field' => 'pad_id']) ?>

<?= Html::submitButton('Save') ?>

<?php ActiveForm::end(); ?>


