<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RefundPayment Entity
 *
 * @property int $id
 * @property int $booking_id
 * @property int $customer_id
 * @property float $payment_price
 * @property string|null $bill_type
 * @property string|null $payment_method
 * @property \Cake\I18n\FrozenDate|null $payment_date
 * @property string|null $payment_time
 * @property string|null $description
 *
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\Customer $customer
 */
class RefundPayment extends Entity
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
        'customer_id' => true,
        'payment_price' => true,
        'bill_type' => true,
        'payment_method' => true,
        'payment_date' => true,
        'payment_time' => true,
        'description' => true,
        'booking' => true,
        'customer' => true
    ];
}
