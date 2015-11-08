<?php $this->extend('/Layout/default'); ?>

<?= $this->cell('Pads', ['auth' => 'auth_param']); ?>

<div class="thirteen columns content-area">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>
