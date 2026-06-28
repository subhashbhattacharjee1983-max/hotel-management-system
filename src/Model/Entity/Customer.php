<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string|null $full_name
 * @property string|null $email_address
 * @property string|null $mobile_number
 * @property string|null $guest_category
 * @property string|null $id_type
 * @property string|null $id_number
 * @property string|null $address
 * @property string|null $image
 * @property string $status
 *
 * @property \App\Model\Entity\Booking[] $bookings
 * @property \App\Model\Entity\Reservation[] $reservations
 */
class Customer extends Entity
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
        'full_name' => true,
        'email_address' => true,
        'mobile_number' => true,
        'guest_category' => true,
        'id_type' => true,
        'id_number' => true,
        'address' => true,
        'image' => true,
        'status' => true,
        'bookings' => true,
        'reservations' => true
    ];
}
