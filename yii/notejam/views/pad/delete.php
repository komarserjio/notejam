<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $model->name;
?>

<?php $form = ActiveForm::begin(); ?>

    <p>Are you sure you want to delete <?= $this->title ?>?</p>
    <?= Html::submitButton('Yes, delete I want to delete this note', ['class' => 'red']) ?>&nbsp;
    <a href="<?= Url::toRoute(['pad/edit', 'id' => $model->id]); ?>">Cancel</a>

<?php ActiveForm::end(); ?>

