<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoomService $roomService
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Room Service'), ['action' => 'edit', $roomService->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Room Service'), ['action' => 'delete', $roomService->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roomService->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Room Services'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room Service'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Service Categories'), ['controller' => 'ServiceCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Service Category'), ['controller' => 'ServiceCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Housekeeping Orders'), ['controller' => 'HousekeepingOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Housekeeping Order'), ['controller' => 'HousekeepingOrders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roomServices view large-9 medium-8 columns content">
    <h3><?= h($roomService->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Service Category') ?></th>
            <td><?= $roomService->has('service_category') ? $this->Html->link($roomService->service_category->id, ['controller' => 'ServiceCategories', 'action' => 'view', $roomService->service_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Service Name') ?></th>
            <td><?= h($roomService->service_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($roomService->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($roomService->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($roomService->price) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($roomService->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Housekeeping Orders') ?></h4>
        <?php if (!empty($roomService->housekeeping_orders)): ?>
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
            <?php foreach ($roomService->housekeeping_orders as $housekeepingOrders): ?>
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
