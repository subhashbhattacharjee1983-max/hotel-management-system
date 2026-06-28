<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReservationPayment $reservationPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Reservation Payment'), ['action' => 'edit', $reservationPayment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reservation Payment'), ['action' => 'delete', $reservationPayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservationPayment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reservation Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="reservationPayments view large-9 medium-8 columns content">
    <h3><?= h($reservationPayment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Reservation') ?></th>
            <td><?= $reservationPayment->has('reservation') ? $this->Html->link($reservationPayment->reservation->id, ['controller' => 'Reservations', 'action' => 'view', $reservationPayment->reservation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bill Type') ?></th>
            <td><?= h($reservationPayment->bill_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Method') ?></th>
            <td><?= h($reservationPayment->payment_method) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Time') ?></th>
            <td><?= h($reservationPayment->payment_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($reservationPayment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Price') ?></th>
            <td><?= $this->Number->format($reservationPayment->payment_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Date') ?></th>
            <td><?= h($reservationPayment->payment_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($reservationPayment->description)); ?>
    </div>
</div>
