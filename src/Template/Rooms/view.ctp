<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Room'), ['action' => 'edit', $room->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Room'), ['action' => 'delete', $room->id], ['confirm' => __('Are you sure you want to delete # {0}?', $room->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Room Categories'), ['controller' => 'RoomCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room Category'), ['controller' => 'RoomCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Housekeeping Orders'), ['controller' => 'HousekeepingOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Housekeeping Order'), ['controller' => 'HousekeepingOrders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rooms view large-9 medium-8 columns content">
    <h3><?= h($room->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Room Category') ?></th>
            <td><?= $room->has('room_category') ? $this->Html->link($room->room_category->id, ['controller' => 'RoomCategories', 'action' => 'view', $room->room_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room Status') ?></th>
            <td><?= h($room->room_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($room->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($room->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room Number') ?></th>
            <td><?= $this->Number->format($room->room_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Floor') ?></th>
            <td><?= $this->Number->format($room->floor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= $this->Number->format($room->description) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Housekeeping Orders') ?></h4>
        <?php if (!empty($room->housekeeping_orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Booking Id') ?></th>
                <th scope="col"><?= __('Room Id') ?></th>
                <th scope="col"><?= __('Room Service Id') ?></th>
                <th scope="col"><?= __('Service Name') ?></th>
                <th scope="col"><?= __('Service Price') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Sub Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($room->housekeeping_orders as $housekeepingOrders): ?>
            <tr>
                <td><?= h($housekeepingOrders->id) ?></td>
                <td><?= h($housekeepingOrders->booking_id) ?></td>
                <td><?= h($housekeepingOrders->room_id) ?></td>
                <td><?= h($housekeepingOrders->room_service_id) ?></td>
                <td><?= h($housekeepingOrders->service_name) ?></td>
                <td><?= h($housekeepingOrders->service_price) ?></td>
                <td><?= h($housekeepingOrders->quantity) ?></td>
                <td><?= h($housekeepingOrders->sub_total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'HousekeepingOrders', 'action' => 'view', $housekeepingOrders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'HousekeepingOrders', 'action' => 'edit', $housekeepingOrders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'HousekeepingOrders', 'action' => 'delete', $housekeepingOrders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $housekeepingOrders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
