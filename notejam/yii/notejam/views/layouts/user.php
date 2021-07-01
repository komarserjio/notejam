<?php $this->beginBlock('pads'); ?>
<?php $this->endBlock(); ?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div class="sixteen columns content-area">
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
