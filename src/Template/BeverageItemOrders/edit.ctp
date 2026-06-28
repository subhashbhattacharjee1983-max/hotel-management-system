<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BeverageItemOrder $beverageItemOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $beverageItemOrder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $beverageItemOrder->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Beverage Item Orders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Beverage Item Details'), ['controller' => 'BeverageItemDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Beverage Item Detail'), ['controller' => 'BeverageItemDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="beverageItemOrders form large-9 medium-8 columns content">
    <?= $this->Form->create($beverageItemOrder) ?>
    <fieldset>
        <legend><?= __('Edit Beverage Item Order') ?></legend>
        <?php
            echo $this->Form->control('booking_id', ['options' => $bookings]);
            echo $this->Form->control('admin_id', ['options' => $admins]);
            echo $this->Form->control('order_type');
            echo $this->Form->control('table_number');
            echo $this->Form->control('guest_name');
            echo $this->Form->control('mobile_number');
            echo $this->Form->control('number_of_persion');
            echo $this->Form->control('special_note');
            echo $this->Form->control('room_ids');
            echo $this->Form->control('sub_total');
            echo $this->Form->control('grand_total');
            echo $this->Form->control('is_payment');
            echo $this->Form->control('payment_method');
            echo $this->Form->control('order_date', ['empty' => true]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
