<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FoodItemDetail $foodItemDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Food Item Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Food Item Orders'), ['controller' => 'FoodItemOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Food Item Order'), ['controller' => 'FoodItemOrders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Food Categories'), ['controller' => 'FoodCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Food Category'), ['controller' => 'FoodCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Food Items'), ['controller' => 'FoodItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Food Item'), ['controller' => 'FoodItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="foodItemDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($foodItemDetail) ?>
    <fieldset>
        <legend><?= __('Add Food Item Detail') ?></legend>
        <?php
            echo $this->Form->control('food_item_order_id', ['options' => $foodItemOrders]);
            echo $this->Form->control('food_category_id', ['options' => $foodCategories]);
            echo $this->Form->control('food_item_id', ['options' => $foodItems]);
            echo $this->Form->control('food_item_name');
            echo $this->Form->control('price');
            echo $this->Form->control('quantity');
            echo $this->Form->control('sub_total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
