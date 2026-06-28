<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FoodItem $foodItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Food Item'), ['action' => 'edit', $foodItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Food Item'), ['action' => 'delete', $foodItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foodItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Food Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Categories'), ['controller' => 'FoodCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Category'), ['controller' => 'FoodCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Item Details'), ['controller' => 'FoodItemDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item Detail'), ['controller' => 'FoodItemDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="foodItems view large-9 medium-8 columns content">
    <h3><?= h($foodItem->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Food Category') ?></th>
            <td><?= $foodItem->has('food_category') ? $this->Html->link($foodItem->food_category->id, ['controller' => 'FoodCategories', 'action' => 'view', $foodItem->food_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Food Item Name') ?></th>
            <td><?= h($foodItem->food_item_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($foodItem->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($foodItem->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Food Item Price') ?></th>
            <td><?= $this->Number->format($foodItem->food_item_price) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($foodItem->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Food Item Details') ?></h4>
        <?php if (!empty($foodItem->food_item_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Food Item Order Id') ?></th>
                <th scope="col"><?= __('Food Category Id') ?></th>
                <th scope="col"><?= __('Food Item Id') ?></th>
                <th scope="col"><?= __('Food Item Name') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Sub Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($foodItem->food_item_details as $foodItemDetails): ?>
            <tr>
                <td><?= h($foodItemDetails->id) ?></td>
                <td><?= h($foodItemDetails->food_item_order_id) ?></td>
                <td><?= h($foodItemDetails->food_category_id) ?></td>
                <td><?= h($foodItemDetails->food_item_id) ?></td>
                <td><?= h($foodItemDetails->food_item_name) ?></td>
                <td><?= h($foodItemDetails->price) ?></td>
                <td><?= h($foodItemDetails->quantity) ?></td>
                <td><?= h($foodItemDetails->sub_total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FoodItemDetails', 'action' => 'view', $foodItemDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FoodItemDetails', 'action' => 'edit', $foodItemDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FoodItemDetails', 'action' => 'delete', $foodItemDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foodItemDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
