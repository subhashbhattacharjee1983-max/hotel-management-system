<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoomCategory $roomCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Room Category'), ['action' => 'edit', $roomCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Room Category'), ['action' => 'delete', $roomCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roomCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Room Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reservations'), ['controller' => 'Reservations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation'), ['controller' => 'Reservations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roomCategories view large-9 medium-8 columns content">
    <h3><?= h($roomCategory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Room Category Name') ?></th>
            <td><?= h($roomCategory->room_category_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($roomCategory->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($roomCategory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price Per Night') ?></th>
            <td><?= $this->Number->format($roomCategory->price_per_night) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($roomCategory->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reservations') ?></h4>
        <?php if (!empty($roomCategory->reservations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Room Category Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Check In Date') ?></th>
                <th scope="col"><?= __('Check Out Date') ?></th>
                <th scope="col"><?= __('Adults') ?></th>
                <th scope="col"><?= __('Children') ?></th>
                <th scope="col"><?= __('Number Of Night') ?></th>
                <th scope="col"><?= __('Booking Date') ?></th>
                <th scope="col"><?= __('Booking Price') ?></th>
                <th scope="col"><?= __('Room Discount') ?></th>
                <th scope="col"><?= __('Payment Status') ?></th>
                <th scope="col"><?= __('Booking Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($roomCategory->reservations as $reservations): ?>
            <tr>
                <td><?= h($reservations->id) ?></td>
                <td><?= h($reservations->room_category_id) ?></td>
                <td><?= h($reservations->customer_id) ?></td>
                <td><?= h($reservations->check_in_date) ?></td>
                <td><?= h($reservations->check_out_date) ?></td>
                <td><?= h($reservations->adults) ?></td>
                <td><?= h($reservations->children) ?></td>
                <td><?= h($reservations->number_of_night) ?></td>
                <td><?= h($reservations->booking_date) ?></td>
                <td><?= h($reservations->booking_price) ?></td>
                <td><?= h($reservations->room_discount) ?></td>
                <td><?= h($reservations->payment_status) ?></td>
                <td><?= h($reservations->booking_status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Reservations', 'action' => 'view', $reservations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Reservations', 'action' => 'edit', $reservations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reservations', 'action' => 'delete', $reservations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Rooms') ?></h4>
        <?php if (!empty($roomCategory->rooms)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Room Category Id') ?></th>
                <th scope="col"><?= __('Room Number') ?></th>
                <th scope="col"><?= __('Floor') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Room Status') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($roomCategory->rooms as $rooms): ?>
            <tr>
                <td><?= h($rooms->id) ?></td>
                <td><?= h($rooms->room_category_id) ?></td>
                <td><?= h($rooms->room_number) ?></td>
                <td><?= h($rooms->floor) ?></td>
                <td><?= h($rooms->description) ?></td>
                <td><?= h($rooms->room_status) ?></td>
                <td><?= h($rooms->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Rooms', 'action' => 'view', $rooms->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Rooms', 'action' => 'edit', $rooms->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Rooms', 'action' => 'delete', $rooms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rooms->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
