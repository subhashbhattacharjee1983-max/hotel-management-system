<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin $admin
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Admin'), ['action' => 'edit', $admin->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Admin'), ['action' => 'delete', $admin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $admin->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Admins'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Admin'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Beverage Item Orders'), ['controller' => 'BeverageItemOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Beverage Item Order'), ['controller' => 'BeverageItemOrders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Food Item Orders'), ['controller' => 'FoodItemOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Food Item Order'), ['controller' => 'FoodItemOrders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="admins view large-9 medium-8 columns content">
    <h3><?= h($admin->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($admin->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($admin->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($admin->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($admin->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($admin->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Type') ?></th>
            <td><?= $this->Number->format($admin->user_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($admin->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($admin->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Beverage Item Orders') ?></h4>
        <?php if (!empty($admin->beverage_item_orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Booking Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Order Type') ?></th>
                <th scope="col"><?= __('Table Number') ?></th>
                <th scope="col"><?= __('Guest Name') ?></th>
                <th scope="col"><?= __('Mobile Number') ?></th>
                <th scope="col"><?= __('Number Of Persion') ?></th>
                <th scope="col"><?= __('Special Note') ?></th>
                <th scope="col"><?= __('Room Ids') ?></th>
                <th scope="col"><?= __('Sub Total') ?></th>
                <th scope="col"><?= __('Grand Total') ?></th>
                <th scope="col"><?= __('Is Payment') ?></th>
                <th scope="col"><?= __('Payment Method') ?></th>
                <th scope="col"><?= __('Order Date') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->beverage_item_orders as $beverageItemOrders): ?>
            <tr>
                <td><?= h($beverageItemOrders->id) ?></td>
                <td><?= h($beverageItemOrders->booking_id) ?></td>
                <td><?= h($beverageItemOrders->admin_id) ?></td>
                <td><?= h($beverageItemOrders->order_type) ?></td>
                <td><?= h($beverageItemOrders->table_number) ?></td>
                <td><?= h($beverageItemOrders->guest_name) ?></td>
                <td><?= h($beverageItemOrders->mobile_number) ?></td>
                <td><?= h($beverageItemOrders->number_of_persion) ?></td>
                <td><?= h($beverageItemOrders->special_note) ?></td>
                <td><?= h($beverageItemOrders->room_ids) ?></td>
                <td><?= h($beverageItemOrders->sub_total) ?></td>
                <td><?= h($beverageItemOrders->grand_total) ?></td>
                <td><?= h($beverageItemOrders->is_payment) ?></td>
                <td><?= h($beverageItemOrders->payment_method) ?></td>
                <td><?= h($beverageItemOrders->order_date) ?></td>
                <td><?= h($beverageItemOrders->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BeverageItemOrders', 'action' => 'view', $beverageItemOrders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BeverageItemOrders', 'action' => 'edit', $beverageItemOrders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BeverageItemOrders', 'action' => 'delete', $beverageItemOrders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $beverageItemOrders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Food Item Orders') ?></h4>
        <?php if (!empty($admin->food_item_orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Booking Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Order Type') ?></th>
                <th scope="col"><?= __('Table Number') ?></th>
                <th scope="col"><?= __('Guest Name') ?></th>
                <th scope="col"><?= __('Mobile Number') ?></th>
                <th scope="col"><?= __('Number Of Persion') ?></th>
                <th scope="col"><?= __('Special Note') ?></th>
                <th scope="col"><?= __('Room Ids') ?></th>
                <th scope="col"><?= __('Sub Total') ?></th>
                <th scope="col"><?= __('Grand Total') ?></th>
                <th scope="col"><?= __('Is Payment') ?></th>
                <th scope="col"><?= __('Payment Method') ?></th>
                <th scope="col"><?= __('Order Date') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->food_item_orders as $foodItemOrders): ?>
            <tr>
                <td><?= h($foodItemOrders->id) ?></td>
                <td><?= h($foodItemOrders->booking_id) ?></td>
                <td><?= h($foodItemOrders->admin_id) ?></td>
                <td><?= h($foodItemOrders->order_type) ?></td>
                <td><?= h($foodItemOrders->table_number) ?></td>
                <td><?= h($foodItemOrders->guest_name) ?></td>
                <td><?= h($foodItemOrders->mobile_number) ?></td>
                <td><?= h($foodItemOrders->number_of_persion) ?></td>
                <td><?= h($foodItemOrders->special_note) ?></td>
                <td><?= h($foodItemOrders->room_ids) ?></td>
                <td><?= h($foodItemOrders->sub_total) ?></td>
                <td><?= h($foodItemOrders->grand_total) ?></td>
                <td><?= h($foodItemOrders->is_payment) ?></td>
                <td><?= h($foodItemOrders->payment_method) ?></td>
                <td><?= h($foodItemOrders->order_date) ?></td>
                <td><?= h($foodItemOrders->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FoodItemOrders', 'action' => 'view', $foodItemOrders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FoodItemOrders', 'action' => 'edit', $foodItemOrders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FoodItemOrders', 'action' => 'delete', $foodItemOrders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foodItemOrders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
