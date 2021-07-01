<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $pad->name;
?>

<?php $form = ActiveForm::begin(); ?>

    <p>Are you sure you want to delete <?= Html::encode($this->title) ?>?</p>
    <?= Html::submitButton('Yes, delete I want to delete it', ['class' => 'red']) ?>&nbsp;
    <a href="<?= Url::toRoute(['pad/edit', 'id' => $pad->id]); ?>">Cancel</a>

<?php ActiveForm::end(); ?>

