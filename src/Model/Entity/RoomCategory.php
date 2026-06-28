<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoomCategory Entity
 *
 * @property int $id
 * @property string|null $room_category_name
 * @property float $price_per_night
 * @property string|null $description
 * @property string $status
 *
 * @property \App\Model\Entity\Reservation[] $reservations
 * @property \App\Model\Entity\Room[] $rooms
 */
class RoomCategory extends Entity
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
        'room_category_name' => true,
        'price_per_night' => true,
        'description' => true,
        'status' => true,
        'reservations' => true,
        'rooms' => true
    ];
}
