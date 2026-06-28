<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingRoomDetail $bookingRoomDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Booking Room Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bookingRoomDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($bookingRoomDetail) ?>
    <fieldset>
        <legend><?= __('Add Booking Room Detail') ?></legend>
        <?php
            echo $this->Form->control('booking_id', ['options' => $bookings]);
            echo $this->Form->control('booking_room_name');
            echo $this->Form->control('booking_room_category');
            echo $this->Form->control('booking_room_price');
            echo $this->Form->control('booking_room_discount');
            echo $this->Form->control('room_booking_price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
