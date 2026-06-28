<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HousekeepingOrder $housekeepingOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Housekeeping Order'), ['action' => 'edit', $housekeepingOrder->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Housekeeping Order'), ['action' => 'delete', $housekeepingOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $housekeepingOrder->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Housekeeping Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Housekeeping Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Room Services'), ['controller' => 'RoomServices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room Service'), ['controller' => 'RoomServices', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="housekeepingOrders view large-9 medium-8 columns content">
    <h3><?= h($housekeepingOrder->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Booking') ?></th>
            <td><?= $housekeepingOrder->has('booking') ? $this->Html->link($housekeepingOrder->booking->id, ['controller' => 'Bookings', 'action' => 'view', $housekeepingOrder->booking->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room') ?></th>
            <td><?= $housekeepingOrder->has('room') ? $this->Html->link($housekeepingOrder->room->id, ['controller' => 'Rooms', 'action' => 'view', $housekeepingOrder->room->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room Service') ?></th>
            <td><?= $housekeepingOrder->has('room_service') ? $this->Html->link($housekeepingOrder->room_service->id, ['controller' => 'RoomServices', 'action' => 'view', $housekeepingOrder->room_service->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Service Name') ?></th>
            <td><?= h($housekeepingOrder->service_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($housekeepingOrder->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Service Price') ?></th>
            <td><?= $this->Number->format($housekeepingOrder->service_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($housekeepingOrder->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sub Total') ?></th>
            <td><?= $this->Number->format($housekeepingOrder->sub_total) ?></td>
        </tr>
    </table>
</div>
