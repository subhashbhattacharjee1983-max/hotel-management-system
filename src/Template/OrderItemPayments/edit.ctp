<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderItemPayment $orderItemPayment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderItemPayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderItemPayment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Order Item Payments'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="orderItemPayments form large-9 medium-8 columns content">
    <?= $this->Form->create($orderItemPayment) ?>
    <fieldset>
        <legend><?= __('Edit Order Item Payment') ?></legend>
        <?php
            echo $this->Form->control('food_item_order_id');
            echo $this->Form->control('beverage_item_order_id');
            echo $this->Form->control('payment_price');
            echo $this->Form->control('bill_type');
            echo $this->Form->control('payment_method');
            echo $this->Form->control('payment_date', ['empty' => true]);
            echo $this->Form->control('payment_time');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
