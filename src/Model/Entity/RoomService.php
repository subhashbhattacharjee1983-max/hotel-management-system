<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoomService Entity
 *
 * @property int $id
 * @property int $service_category_id
 * @property string|null $service_name
 * @property float $price
 * @property string|null $description
 * @property string $status
 *
 * @property \App\Model\Entity\ServiceCategory $service_category
 * @property \App\Model\Entity\HousekeepingOrder[] $housekeeping_orders
 */
class RoomService extends Entity
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
        'service_category_id' => true,
        'service_name' => true,
        'price' => true,
        'description' => true,
        'status' => true,
        'service_category' => true,
        'housekeeping_orders' => true
    ];
}
