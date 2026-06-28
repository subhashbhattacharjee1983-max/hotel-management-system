<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BeverageCategory $beverageCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Beverage Category'), ['action' => 'edit', $beverageCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Beverage Category'), ['action' => 'delete', $beverageCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beverageCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Item Details'), ['controller' => 'BeverageItemDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Item Detail'), ['controller' => 'BeverageItemDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Items'), ['controller' => 'BeverageItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Item'), ['controller' => 'BeverageItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="beverageCategories view large-9 medium-8 columns content">
    <h3><?= h($beverageCategory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Beverage Item Name') ?></th>
            <td><?= h($beverageCategory->beverage_item_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($beverageCategory->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($beverageCategory->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($beverageCategory->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Beverage Item Details') ?></h4>
        <?php if (!empty($beverageCategory->beverage_item_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Beverage Item Order Id') ?></th>
                <th scope="col"><?= __('Beverage Category Id') ?></th>
                <th scope="col"><?= __('Beverage Item Id') ?></th>
                <th scope="col"><?= __('Beverage Item Name') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Sub Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($beverageCategory->beverage_item_details as $beverageItemDetails): ?>
            <tr>
                <td><?= h($beverageItemDetails->id) ?></td>
                <td><?= h($beverageItemDetails->beverage_item_order_id) ?></td>
                <td><?= h($beverageItemDetails->beverage_category_id) ?></td>
                <td><?= h($beverageItemDetails->beverage_item_id) ?></td>
                <td><?= h($beverageItemDetails->beverage_item_name) ?></td>
                <td><?= h($beverageItemDetails->price) ?></td>
                <td><?= h($beverageItemDetails->quantity) ?></td>
                <td><?= h($beverageItemDetails->sub_total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BeverageItemDetails', 'action' => 'view', $beverageItemDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BeverageItemDetails', 'action' => 'edit', $beverageItemDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BeverageItemDetails', 'action' => 'delete', $beverageItemDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beverageItemDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Beverage Items') ?></h4>
        <?php if (!empty($beverageCategory->beverage_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Beverage Category Id') ?></th>
                <th scope="col"><?= __('Beverage Item Name') ?></th>
                <th scope="col"><?= __('Beverage Item Price') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($beverageCategory->beverage_items as $beverageItems): ?>
            <tr>
                <td><?= h($beverageItems->id) ?></td>
                <td><?= h($beverageItems->beverage_category_id) ?></td>
                <td><?= h($beverageItems->beverage_item_name) ?></td>
                <td><?= h($beverageItems->beverage_item_price) ?></td>
                <td><?= h($beverageItems->description) ?></td>
                <td><?= h($beverageItems->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BeverageItems', 'action' => 'view', $beverageItems->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BeverageItems', 'action' => 'edit', $beverageItems->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BeverageItems', 'action' => 'delete', $beverageItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beverageItems->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
