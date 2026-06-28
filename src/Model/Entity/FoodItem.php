<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FoodItem Entity
 *
 * @property int $id
 * @property int $food_category_id
 * @property string|null $food_item_name
 * @property float $food_item_price
 * @property string|null $description
 * @property string $status
 *
 * @property \App\Model\Entity\FoodCategory $food_category
 * @property \App\Model\Entity\FoodItemDetail[] $food_item_details
 */
class FoodItem extends Entity
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
        'food_category_id' => true,
        'food_item_name' => true,
        'food_item_price' => true,
        'description' => true,
        'status' => true,
        'food_category' => true,
        'food_item_details' => true
    ];
}
