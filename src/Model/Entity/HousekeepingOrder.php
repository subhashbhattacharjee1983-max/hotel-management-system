<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HousekeepingOrder Entity
 *
 * @property int $id
 * @property int $booking_id
 * @property string|null $room_number
 * @property string|null $service_name
 * @property float $service_price
 * @property int $quantity
 * @property float $sub_total
 *
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\RoomService $room_service
 */
class HousekeepingOrder extends Entity
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
        'room_number' => true,
        'service_name' => true,
        'service_price' => true,
        'quantity' => true,
        'sub_total' => true,
        'booking' => true
    ];
}
