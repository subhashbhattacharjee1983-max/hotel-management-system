<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BeverageItemDetail Entity
 *
 * @property int $id
 * @property int $beverage_item_order_id
 * @property int $beverage_category_id
 * @property int $beverage_item_id
 * @property int $booking_id
 * @property string $beverage_item_category
 * @property string $beverage_item_name
 * @property float $price
 * @property int $quantity
 * @property float $sub_total
 * @property \Cake\I18n\FrozenTime|null $order_date
 *
 * @property \App\Model\Entity\BeverageItemOrder $beverage_item_order
 * @property \App\Model\Entity\BeverageCategory $beverage_category
 * @property \App\Model\Entity\BeverageItem $beverage_item
 */
class BeverageItemDetail extends Entity
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
        'beverage_item_order_id' => true,
        'beverage_category_id' => true,
        'beverage_item_id' => true,
		'booking_id' => true,
        'beverage_item_category' => true,
        'beverage_item_name' => true,
        'price' => true,
        'quantity' => true,
        'sub_total' => true,
		'order_date' => true,
        'beverage_item_order' => true,
        'beverage_category' => true,
        'beverage_item' => true
    ];
}
