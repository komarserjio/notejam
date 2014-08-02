<?php $this->beginBlock('pads'); ?>
    <div class="three columns">
      <h4 id="logo">My pads</h4>
      <nav>
      <ul>
        <li><a href="#whatAndWhy">Business</a></li>
        <li><a href="#grid">Personal</a></li>
        <li><a href="#typography">Sport</a></li>
        <li><a href="#buttons">Diary</a></li>
        <li><a href="#forms">Drafts</a></li>
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

