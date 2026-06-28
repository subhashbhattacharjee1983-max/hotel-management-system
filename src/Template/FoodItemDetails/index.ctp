<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FoodItemDetail[]|\Cake\Collection\CollectionInterface $foodItemDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Food Item Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Food Item Orders'), ['controller' => 'FoodItemOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Food Item Order'), ['controller' => 'FoodItemOrders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Food Categories'), ['controller' => 'FoodCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Food Category'), ['controller' => 'FoodCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Food Items'), ['controller' => 'FoodItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Food Item'), ['controller' => 'FoodItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="foodItemDetails index large-9 medium-8 columns content">
    <h3><?= __('Food Item Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('food_item_order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('food_category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('food_item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('food_item_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sub_total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($foodItemDetails as $foodItemDetail): ?>
            <tr>
                <td><?= $this->Number->format($foodItemDetail->id) ?></td>
                <td><?= $foodItemDetail->has('food_item_order') ? $this->Html->link($foodItemDetail->food_item_order->id, ['controller' => 'FoodItemOrders', 'action' => 'view', $foodItemDetail->food_item_order->id]) : '' ?></td>
                <td><?= $foodItemDetail->has('food_category') ? $this->Html->link($foodItemDetail->food_category->id, ['controller' => 'FoodCategories', 'action' => 'view', $foodItemDetail->food_category->id]) : '' ?></td>
                <td><?= $foodItemDetail->has('food_item') ? $this->Html->link($foodItemDetail->food_item->id, ['controller' => 'FoodItems', 'action' => 'view', $foodItemDetail->food_item->id]) : '' ?></td>
                <td><?= h($foodItemDetail->food_item_name) ?></td>
                <td><?= $this->Number->format($foodItemDetail->price) ?></td>
                <td><?= $this->Number->format($foodItemDetail->quantity) ?></td>
                <td><?= $this->Number->format($foodItemDetail->sub_total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $foodItemDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $foodItemDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $foodItemDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foodItemDetail->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
