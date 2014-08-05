<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $note->name;
?>

<p class="hidden-text">Last edited at <?= $note->getSmartDate(); ?></p>
<div class="note">
    <p>
        <?= $note->text ?>
    </p>
</div>
<a href="<?= Url::toRoute(['note/edit', 'id' => $note->id]) ?>" class="button">Edit</a>
<a href="<?= Url::toRoute(['note/delete', 'id' => $note->id]) ?>" class="delete-note">Delete it</a>
