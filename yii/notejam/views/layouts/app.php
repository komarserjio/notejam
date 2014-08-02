<?php $this->beginBlock('pads'); ?>
    <div class="three columns">
      <h4 id="logo">My pads</h4>
      <nav>
          <ul>
            <?php foreach(Yii::$app->user->identity->pads as $pad): ?>
                <li><a href="#whatAndWhy"><?= $pad->name; ?></a></li>
            <?php endforeach; ?>
          </ul>
          <hr />
      <a href="#">New pad</a>
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

