<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingRoomDetail $bookingRoomDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Booking Room Detail'), ['action' => 'edit', $bookingRoomDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Booking Room Detail'), ['action' => 'delete', $bookingRoomDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingRoomDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Booking Room Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking Room Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bookingRoomDetails view large-9 medium-8 columns content">
    <h3><?= h($bookingRoomDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Booking') ?></th>
            <td><?= $bookingRoomDetail->has('booking') ? $this->Html->link($bookingRoomDetail->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingRoomDetail->booking->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Booking Room Name') ?></th>
            <td><?= h($bookingRoomDetail->booking_room_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Booking Room Category') ?></th>
            <td><?= h($bookingRoomDetail->booking_room_category) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bookingRoomDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Booking Room Price') ?></th>
            <td><?= $this->Number->format($bookingRoomDetail->booking_room_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Booking Room Discount') ?></th>
            <td><?= $this->Number->format($bookingRoomDetail->booking_room_discount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room Booking Price') ?></th>
            <td><?= $this->Number->format($bookingRoomDetail->room_booking_price) ?></td>
        </tr>
    </table>
</div>
