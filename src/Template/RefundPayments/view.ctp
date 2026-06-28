<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RefundPayment $refundPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Refund Payment'), ['action' => 'edit', $refundPayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Refund Payment'), ['action' => 'delete', $refundPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $refundPayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Refund Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Refund Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="refundPayments view large-9 medium-8 columns content">
    <h3><?= h($refundPayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Booking') ?></th>
            <td><?= $refundPayment->has('booking') ? $this->Html->link($refundPayment->booking->id, ['controller' => 'Bookings', 'action' => 'view', $refundPayment->booking->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $refundPayment->has('customer') ? $this->Html->link($refundPayment->customer->id, ['controller' => 'Customers', 'action' => 'view', $refundPayment->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bill Type') ?></th>
            <td><?= h($refundPayment->bill_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Method') ?></th>
            <td><?= h($refundPayment->payment_method) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Time') ?></th>
            <td><?= h($refundPayment->payment_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($refundPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Price') ?></th>
            <td><?= $this->Number->format($refundPayment->payment_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Date') ?></th>
            <td><?= h($refundPayment->payment_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($refundPayment->description)); ?>
    </div>
</div>
