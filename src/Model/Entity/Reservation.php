<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reservation Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property \Cake\I18n\FrozenDate|null $check_in_date
 * @property \Cake\I18n\FrozenDate|null $check_out_date
 * @property int $adults
 * @property int $children
 * @property int $number_of_night
 * @property float $room_price
 * @property \Cake\I18n\FrozenTime $booking_date
 * @property float $booking_price
 * @property float $room_discount
 * @property string $payment_status
 * @property string $booking_status
 * @property string $booking_type
 * @property string $booking_package
 * @property string $booked_by 
 * @property string $food_plan
 * @property string $allow_bst
 * @property string $allow_gst
 * @property string $allow_service_charge
 * @property string $allow_bank_transfer_charge
 * @property int $bst_tax
 * @property int $service_tax
 * @property int $gst_tax
 * @property string $bank_transfer_charge
 * @property string $food1
 * @property int $food_price1
 * @property int $food_total1
 * @property string $food2
 * @property int $food_price2
 * @property int $food_total2
 * @property string $food3
 * @property int $food_price3
 * @property int $food_total3
 * @property string $food4
 * @property int $food_price4
 * @property int $food_total4
 * @property int $paid_amount
 * @property int $all_total_amount
 *
 * @property \App\Model\Entity\RoomCategory $room_category
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\ReservationPayment[] $reservation_payments
 */
class Reservation extends Entity
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
        'customer_id' => true,
        'check_in_date' => true,
        'check_out_date' => true,
        'adults' => true,
        'children' => true,		
        'number_of_night' => true,
		'room_price' => true,
        'booking_date' => true,
        'booking_price' => true,
        'room_discount' => true,
        'booking_status' => true,
		'booking_type' => true,
		'booking_package' => true,
		'booked_by' => true,
		'food_plan' => true,
		'allow_bst' => true,
		'allow_gst' => true,
		'allow_service_charge' => true,
		'allow_bank_transfer_charge' => true,
		'bst_tax' => true,
		'service_tax' => true,
		'gst_tax' => true,
		'bank_transfer_charge' => true,
		'food1' => true,
		'food_price1' => true,
		'food_total1' => true,
		'food2' => true,
		'food_price2' => true,
		'food_total2' => true,
		'food3' => true,
		'food_price3' => true,
		'food_total3' => true,
		'food4' => true,
		'food_price4' => true,
		'food_total4' => true,
		'paid_amount' => true,
		'all_total_amount' => true,
        'room_category' => true,
        'customer' => true,
        'reservation_payments' => true
    ];
}
