<div class="three columns">
    <h4 id="logo"><?= __("My pads"); ?></h4>
    <nav>
        <ul>
            <?php if ($pads): ?>
                <?php foreach($pads as $pad): ?>
                    <li><?= $this->Html->link($pad->name, ['id' => $pad->id, '_name' => 'view_pad']) ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty">No pads yet</p>
            <?php endif; ?>
        </ul>
        <hr />
        <?= $this->Html->link(__("New pad"), ['_name' => 'create_pad']); ?>
    </nav>
</div>
