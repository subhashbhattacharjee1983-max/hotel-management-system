<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Room Entity
 *
 * @property int $id
 * @property int $room_category_id
 * @property int $room_number
 * @property int $floor
 * @property int|null $description
 * @property string $room_status
 * @property string $status
 *
 * @property \App\Model\Entity\RoomCategory $room_category
 * @property \App\Model\Entity\HousekeepingOrder[] $housekeeping_orders
 */
class Room extends Entity
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
        'booking_id' => true,
		'room_category_id' => true,
        'room_number' => true,
        'floor' => true,
        'description' => true,
        'room_status' => true,
        'status' => true,
        'room_category' => true,
        'housekeeping_orders' => true
    ];
}
