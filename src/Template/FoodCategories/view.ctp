<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FoodCategory $foodCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Food Category'), ['action' => 'edit', $foodCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Food Category'), ['action' => 'delete', $foodCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foodCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Food Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Item Details'), ['controller' => 'FoodItemDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item Detail'), ['controller' => 'FoodItemDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Items'), ['controller' => 'FoodItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item'), ['controller' => 'FoodItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="foodCategories view large-9 medium-8 columns content">
    <h3><?= h($foodCategory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Food Item Name') ?></th>
            <td><?= h($foodCategory->food_item_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($foodCategory->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($foodCategory->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($foodCategory->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Food Item Details') ?></h4>
        <?php if (!empty($foodCategory->food_item_details)): ?>
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
            <?php foreach ($foodCategory->food_item_details as $foodItemDetails): ?>
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
    <div class="related">
        <h4><?= __('Related Food Items') ?></h4>
        <?php if (!empty($foodCategory->food_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Food Category Id') ?></th>
                <th scope="col"><?= __('Food Item Name') ?></th>
                <th scope="col"><?= __('Food Item Price') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($foodCategory->food_items as $foodItems): ?>
            <tr>
                <td><?= h($foodItems->id) ?></td>
                <td><?= h($foodItems->food_category_id) ?></td>
                <td><?= h($foodItems->food_item_name) ?></td>
                <td><?= h($foodItems->food_item_price) ?></td>
                <td><?= h($foodItems->description) ?></td>
                <td><?= h($foodItems->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FoodItems', 'action' => 'view', $foodItems->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FoodItems', 'action' => 'edit', $foodItems->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FoodItems', 'action' => 'delete', $foodItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foodItems->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
