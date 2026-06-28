<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BeverageItemDetail $beverageItemDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Beverage Item Detail'), ['action' => 'edit', $beverageItemDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Beverage Item Detail'), ['action' => 'delete', $beverageItemDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beverageItemDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Item Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Item Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Item Orders'), ['controller' => 'BeverageItemOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Item Order'), ['controller' => 'BeverageItemOrders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Categories'), ['controller' => 'BeverageCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Category'), ['controller' => 'BeverageCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Items'), ['controller' => 'BeverageItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Item'), ['controller' => 'BeverageItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="beverageItemDetails view large-9 medium-8 columns content">
    <h3><?= h($beverageItemDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Beverage Item Order') ?></th>
            <td><?= $beverageItemDetail->has('beverage_item_order') ? $this->Html->link($beverageItemDetail->beverage_item_order->id, ['controller' => 'BeverageItemOrders', 'action' => 'view', $beverageItemDetail->beverage_item_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Beverage Category') ?></th>
            <td><?= $beverageItemDetail->has('beverage_category') ? $this->Html->link($beverageItemDetail->beverage_category->id, ['controller' => 'BeverageCategories', 'action' => 'view', $beverageItemDetail->beverage_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Beverage Item') ?></th>
            <td><?= $beverageItemDetail->has('beverage_item') ? $this->Html->link($beverageItemDetail->beverage_item->id, ['controller' => 'BeverageItems', 'action' => 'view', $beverageItemDetail->beverage_item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Beverage Item Name') ?></th>
            <td><?= h($beverageItemDetail->beverage_item_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($beverageItemDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($beverageItemDetail->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($beverageItemDetail->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sub Total') ?></th>
            <td><?= $this->Number->format($beverageItemDetail->sub_total) ?></td>
        </tr>
    </table>
</div>
