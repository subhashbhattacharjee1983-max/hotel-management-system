<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FoodItemDetail $foodItemDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Food Item Detail'), ['action' => 'edit', $foodItemDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Food Item Detail'), ['action' => 'delete', $foodItemDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foodItemDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Food Item Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Item Orders'), ['controller' => 'FoodItemOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item Order'), ['controller' => 'FoodItemOrders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Categories'), ['controller' => 'FoodCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Category'), ['controller' => 'FoodCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Items'), ['controller' => 'FoodItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item'), ['controller' => 'FoodItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="foodItemDetails view large-9 medium-8 columns content">
    <h3><?= h($foodItemDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Food Item Order') ?></th>
            <td><?= $foodItemDetail->has('food_item_order') ? $this->Html->link($foodItemDetail->food_item_order->id, ['controller' => 'FoodItemOrders', 'action' => 'view', $foodItemDetail->food_item_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Food Category') ?></th>
            <td><?= $foodItemDetail->has('food_category') ? $this->Html->link($foodItemDetail->food_category->id, ['controller' => 'FoodCategories', 'action' => 'view', $foodItemDetail->food_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Food Item') ?></th>
            <td><?= $foodItemDetail->has('food_item') ? $this->Html->link($foodItemDetail->food_item->id, ['controller' => 'FoodItems', 'action' => 'view', $foodItemDetail->food_item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Food Item Name') ?></th>
            <td><?= h($foodItemDetail->food_item_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($foodItemDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($foodItemDetail->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($foodItemDetail->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sub Total') ?></th>
            <td><?= $this->Number->format($foodItemDetail->sub_total) ?></td>
        </tr>
    </table>
</div>
