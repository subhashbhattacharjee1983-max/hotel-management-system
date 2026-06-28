<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RefundPayment $refundPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $refundPayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $refundPayment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Refund Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="refundPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($refundPayment) ?>
    <fieldset>
        <legend><?= __('Edit Refund Payment') ?></legend>
        <?php
            echo $this->Form->control('booking_id', ['options' => $bookings]);
            echo $this->Form->control('customer_id', ['options' => $customers]);
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
