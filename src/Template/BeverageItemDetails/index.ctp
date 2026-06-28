<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BeverageItemDetail[]|\Cake\Collection\CollectionInterface $beverageItemDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Beverage Item Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Beverage Item Orders'), ['controller' => 'BeverageItemOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Beverage Item Order'), ['controller' => 'BeverageItemOrders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Beverage Categories'), ['controller' => 'BeverageCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Beverage Category'), ['controller' => 'BeverageCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Beverage Items'), ['controller' => 'BeverageItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Beverage Item'), ['controller' => 'BeverageItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="beverageItemDetails index large-9 medium-8 columns content">
    <h3><?= __('Beverage Item Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('beverage_item_order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('beverage_category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('beverage_item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('beverage_item_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sub_total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beverageItemDetails as $beverageItemDetail): ?>
            <tr>
                <td><?= $this->Number->format($beverageItemDetail->id) ?></td>
                <td><?= $beverageItemDetail->has('beverage_item_order') ? $this->Html->link($beverageItemDetail->beverage_item_order->id, ['controller' => 'BeverageItemOrders', 'action' => 'view', $beverageItemDetail->beverage_item_order->id]) : '' ?></td>
                <td><?= $beverageItemDetail->has('beverage_category') ? $this->Html->link($beverageItemDetail->beverage_category->id, ['controller' => 'BeverageCategories', 'action' => 'view', $beverageItemDetail->beverage_category->id]) : '' ?></td>
                <td><?= $beverageItemDetail->has('beverage_item') ? $this->Html->link($beverageItemDetail->beverage_item->id, ['controller' => 'BeverageItems', 'action' => 'view', $beverageItemDetail->beverage_item->id]) : '' ?></td>
                <td><?= h($beverageItemDetail->beverage_item_name) ?></td>
                <td><?= $this->Number->format($beverageItemDetail->price) ?></td>
                <td><?= $this->Number->format($beverageItemDetail->quantity) ?></td>
                <td><?= $this->Number->format($beverageItemDetail->sub_total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $beverageItemDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $beverageItemDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $beverageItemDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beverageItemDetail->id)]) ?>
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
