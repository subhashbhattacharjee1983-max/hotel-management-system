<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FoodCategory Entity
 *
 * @property int $id
 * @property string|null $food_item_name
 * @property string|null $description
 * @property string $status
 *
 * @property \App\Model\Entity\FoodItemDetail[] $food_item_details
 * @property \App\Model\Entity\FoodItem[] $food_items
 */
class FoodCategory extends Entity
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
        'food_item_name' => true,
        'description' => true,
        'status' => true,
        'food_item_details' => true,
        'food_items' => true
    ];
}
