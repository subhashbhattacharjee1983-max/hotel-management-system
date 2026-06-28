<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HousekeepingOrder $housekeepingOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $housekeepingOrder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $housekeepingOrder->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Housekeeping Orders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Room Services'), ['controller' => 'RoomServices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Room Service'), ['controller' => 'RoomServices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="housekeepingOrders form large-9 medium-8 columns content">
    <?= $this->Form->create($housekeepingOrder) ?>
    <fieldset>
        <legend><?= __('Edit Housekeeping Order') ?></legend>
        <?php
            echo $this->Form->control('booking_id', ['options' => $bookings]);
            echo $this->Form->control('room_id', ['options' => $rooms]);
            echo $this->Form->control('room_service_id', ['options' => $roomServices]);
            echo $this->Form->control('service_name');
            echo $this->Form->control('service_price');
            echo $this->Form->control('quantity');
            echo $this->Form->control('sub_total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
