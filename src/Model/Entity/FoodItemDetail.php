<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FoodItemDetail Entity
 *
 * @property int $id
 * @property int $food_item_order_id
 * @property int $food_category_id
 * @property int $food_item_id
 * @property int $booking_id
 * @property string $food_item_category
 * @property string $food_item_name
 * @property float $price
 * @property int $quantity
 * @property int $item_no_of_days
 * @property float $sub_total
 * @property \Cake\I18n\FrozenTime|null $order_date
 *
 * @property \App\Model\Entity\FoodItemOrder $food_item_order
 * @property \App\Model\Entity\FoodCategory $food_category
 * @property \App\Model\Entity\FoodItem $food_item
 */
class FoodItemDetail extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'food_item_order_id' => true,
        'food_category_id' => true,
        'food_item_id' => true,
		'booking_id' => true,
        'food_item_category' => true,
		'food_item_name' => true,
        'price' => true,
        'quantity' => true,
		'item_no_of_days' => true,
        'sub_total' => true,
		'order_date' => true,
        'food_item_order' => true,
        'food_category' => true,
        'food_item' => true
    ];
}
