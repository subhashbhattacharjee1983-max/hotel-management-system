<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReservationPayment $reservationPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $reservationPayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reservationPayment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Reservation Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="reservationPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($reservationPayment) ?>
    <fieldset>
        <legend><?= __('Edit Reservation Payment') ?></legend>
        <?php
            echo $this->Form->control('reservation_id', ['options' => $reservations]);
            echo $this->Form->control('payment_price');
            echo $this->Form->control('bill_type');
            echo $this->Form->control('payment_method');
            echo $this->Form->control('payment_date', ['empty' => true]);
            echo $this->Form->control('payment_time');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
