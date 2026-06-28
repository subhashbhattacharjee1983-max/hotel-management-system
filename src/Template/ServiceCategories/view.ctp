<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ServiceCategory $serviceCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Service Category'), ['action' => 'edit', $serviceCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Service Category'), ['action' => 'delete', $serviceCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $serviceCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Service Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Service Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Room Services'), ['controller' => 'RoomServices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room Service'), ['controller' => 'RoomServices', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="serviceCategories view large-9 medium-8 columns content">
    <h3><?= h($serviceCategory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Category Name') ?></th>
            <td><?= h($serviceCategory->category_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($serviceCategory->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($serviceCategory->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($serviceCategory->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Room Services') ?></h4>
        <?php if (!empty($serviceCategory->room_services)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Service Category Id') ?></th>
                <th scope="col"><?= __('Service Name') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($serviceCategory->room_services as $roomServices): ?>
            <tr>
                <td><?= h($roomServices->id) ?></td>
                <td><?= h($roomServices->service_category_id) ?></td>
                <td><?= h($roomServices->service_name) ?></td>
                <td><?= h($roomServices->price) ?></td>
                <td><?= h($roomServices->description) ?></td>
                <td><?= h($roomServices->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RoomServices', 'action' => 'view', $roomServices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RoomServices', 'action' => 'edit', $roomServices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RoomServices', 'action' => 'delete', $roomServices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roomServices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
