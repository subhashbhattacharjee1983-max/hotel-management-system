<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingPayment $bookingPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Booking Payment'), ['action' => 'edit', $bookingPayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Booking Payment'), ['action' => 'delete', $bookingPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingPayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Booking Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bookingPayments view large-9 medium-8 columns content">
    <h3><?= h($bookingPayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Booking') ?></th>
            <td><?= $bookingPayment->has('booking') ? $this->Html->link($bookingPayment->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingPayment->booking->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bill Type') ?></th>
            <td><?= h($bookingPayment->bill_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Method') ?></th>
            <td><?= h($bookingPayment->payment_method) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Time') ?></th>
            <td><?= h($bookingPayment->payment_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bookingPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Price') ?></th>
            <td><?= $this->Number->format($bookingPayment->payment_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Date') ?></th>
            <td><?= h($bookingPayment->payment_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($bookingPayment->description)); ?>
    </div>
</div>
