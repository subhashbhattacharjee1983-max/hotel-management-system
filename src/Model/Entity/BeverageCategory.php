<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BeverageCategory Entity
 *
 * @property int $id
 * @property string|null $beverage_item_name
 * @property string|null $description
 * @property string $status
 *
 * @property \App\Model\Entity\BeverageItemDetail[] $beverage_item_details
 * @property \App\Model\Entity\BeverageItem[] $beverage_items
 */
class BeverageCategory extends Entity
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
        'beverage_item_name' => true,
        'description' => true,
        'status' => true,
        'beverage_item_details' => true,
        'beverage_items' => true
    ];
}
