<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingRoomDetail[]|\Cake\Collection\CollectionInterface $bookingRoomDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Booking Room Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bookingRoomDetails index large-9 medium-8 columns content">
    <h3><?= __('Booking Room Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('booking_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('booking_room_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('booking_room_category') ?></th>
                <th scope="col"><?= $this->Paginator->sort('booking_room_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('booking_room_discount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('room_booking_price') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookingRoomDetails as $bookingRoomDetail): ?>
            <tr>
                <td><?= $this->Number->format($bookingRoomDetail->id) ?></td>
                <td><?= $bookingRoomDetail->has('booking') ? $this->Html->link($bookingRoomDetail->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingRoomDetail->booking->id]) : '' ?></td>
                <td><?= h($bookingRoomDetail->booking_room_name) ?></td>
                <td><?= h($bookingRoomDetail->booking_room_category) ?></td>
                <td><?= $this->Number->format($bookingRoomDetail->booking_room_price) ?></td>
                <td><?= $this->Number->format($bookingRoomDetail->booking_room_discount) ?></td>
                <td><?= $this->Number->format($bookingRoomDetail->room_booking_price) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bookingRoomDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bookingRoomDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bookingRoomDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingRoomDetail->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
