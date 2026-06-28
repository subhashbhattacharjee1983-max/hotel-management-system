<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderItemPayment $orderItemPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order Item Payment'), ['action' => 'edit', $orderItemPayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order Item Payment'), ['action' => 'delete', $orderItemPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderItemPayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Order Item Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Item Payment'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orderItemPayments view large-9 medium-8 columns content">
    <h3><?= h($orderItemPayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bill Type') ?></th>
            <td><?= h($orderItemPayment->bill_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Method') ?></th>
            <td><?= h($orderItemPayment->payment_method) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Time') ?></th>
            <td><?= h($orderItemPayment->payment_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($orderItemPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Food Item Order Id') ?></th>
            <td><?= $this->Number->format($orderItemPayment->food_item_order_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Beverage Item Order Id') ?></th>
            <td><?= $this->Number->format($orderItemPayment->beverage_item_order_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Price') ?></th>
            <td><?= $this->Number->format($orderItemPayment->payment_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Date') ?></th>
            <td><?= h($orderItemPayment->payment_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($orderItemPayment->description)); ?>
    </div>
</div>
