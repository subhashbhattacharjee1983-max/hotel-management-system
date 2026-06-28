<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BeverageItemDetail $beverageItemDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Beverage Item Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Beverage Item Orders'), ['controller' => 'BeverageItemOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Beverage Item Order'), ['controller' => 'BeverageItemOrders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Beverage Categories'), ['controller' => 'BeverageCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Beverage Category'), ['controller' => 'BeverageCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Beverage Items'), ['controller' => 'BeverageItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Beverage Item'), ['controller' => 'BeverageItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="beverageItemDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($beverageItemDetail) ?>
    <fieldset>
        <legend><?= __('Add Beverage Item Detail') ?></legend>
        <?php
            echo $this->Form->control('beverage_item_order_id', ['options' => $beverageItemOrders]);
            echo $this->Form->control('beverage_category_id', ['options' => $beverageCategories]);
            echo $this->Form->control('beverage_item_id', ['options' => $beverageItems]);
            echo $this->Form->control('beverage_item_name');
            echo $this->Form->control('price');
            echo $this->Form->control('quantity');
            echo $this->Form->control('sub_total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
