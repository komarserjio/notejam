<div class="three columns">
    <h4 id="logo">My pads</h4>
    <nav>
        <ul>
            <?php foreach($pads as $pad): ?>
                <li><?= $this->Html->link($pad->name, ['id' => $pad->id, '_name' => 'view_pad']) ?></li>
            <?php endforeach; ?>
        </ul>
        <hr />
        <?= $this->Html->link("New pad", ['_name' => 'create_pad']); ?>
    </nav>
</div>
