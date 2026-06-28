<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReservationRoomDetail Entity
 *
 * @property int $id
 * @property int $reservation_id
 * @property string|null $reservation_room_number
 * @property string|null $reservation_room_category
 * @property float $booking_room_price
 * @property int $booking_room_discount
 * @property float $room_booking_price
 *
 * @property \App\Model\Entity\Reservation $reservation
 */
class ReservationRoomDetail extends Entity
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
        'reservation_id' => true,
        'reservation_room_number' => true,
		'reservation_room_category' => true,
        'booking_room_price' => true,
        'booking_room_discount' => true,
        'room_booking_price' => true,
        'reservation' => true
    ];
}
