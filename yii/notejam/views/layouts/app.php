<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php $this->beginBlock('pads'); ?>
    <div class="three columns">
      <h4 id="logo">My pads</h4>
          <nav>
              <?php if (Yii::$app->user->identity->pads): ?>
                  <ul>
                    <?php foreach(Yii::$app->user->identity->pads as $pad): ?>
                        <li><a href="<?= Url::toRoute(['pad/view', 'id' => $pad->id])?>"><?= Html::encode($pad->name) ?></a></li>
                    <?php endforeach; ?>
                  </ul>
              <?php else: ?>
                   <p class="empty">No pads</p>
              <?php endif; ?>
              <hr />
              <a href="<?= Url::toRoute('pad/create'); ?>">New pad</a>
          </nav>
    </div>
<?php $this->endBlock(); ?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div class="thirteen columns content-area">
      <div class="alert-area">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-error"><?= Yii::$app->session->getFlash('success') ?></div>
        <?php endif; ?>
      </div>
      <?= $content ?>
    </div>
<?php $this->endContent(); ?>
