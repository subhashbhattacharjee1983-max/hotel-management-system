<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BeverageItem Entity
 *
 * @property int $id
 * @property int $beverage_category_id
 * @property string|null $beverage_item_name
 * @property float $beverage_item_price
 * @property string|null $description
 * @property string $status
 *
 * @property \App\Model\Entity\BeverageCategory $beverage_category
 * @property \App\Model\Entity\BeverageItemDetail[] $beverage_item_details
 */
class BeverageItem extends Entity
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
        'beverage_category_id' => true,
        'beverage_item_name' => true,
        'beverage_item_price' => true,
        'description' => true,
        'status' => true,
        'beverage_category' => true,
        'beverage_item_details' => true
    ];
}
