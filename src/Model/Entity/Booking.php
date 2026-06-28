<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Booking Entity
 *
 * @property int $id
 * @property string|null $room_ids
 * @property int $customer_id
 * @property \Cake\I18n\FrozenDate|null $check_in_date
 * @property \Cake\I18n\FrozenDate|null $check_out_date
 * @property int $adults
 * @property int $children
 * @property int $number_of_night
 * @property float $room_price
 * @property \Cake\I18n\FrozenTime|null $booking_date
 * @property float $booking_price
 * @property float $room_discount
 * @property string $payment_status
 * @property string $booking_status
 * @property string $booking_type
 * @property string|null $booked_by
 * @property string|null $booking_package
 * @property string|null $food_plan
 * @property string $allow_bst
 * @property string $allow_service_charge
 * @property string $allow_gst
 * @property string $allow_bank_transfer_charge
 * @property int $bst_tax
 * @property int $service_tax
 * @property int $gst_tax
 * @property string $bank_transfer_charge
 * @property string|null $booking_verified
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\BeverageItemOrder[] $beverage_item_orders
 * @property \App\Model\Entity\BookingPayment[] $booking_payments
 * @property \App\Model\Entity\FoodItemOrder[] $food_item_orders
 * @property \App\Model\Entity\HousekeepingOrder[] $housekeeping_orders
 */
class Booking extends Entity
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
        'payment_status' => true,
        'booking_status' => true,
		'booking_type' => true,
		'booked_by' => true,
		'booking_package' => true,
		'food_plan' => true,
		'allow_bst' => true,		
		'allow_gst' => true,
		'allow_service_charge' => true,
		'allow_bank_transfer_charge' => true,
		'bst_tax' => true,
		'service_tax' => true,
		'gst_tax' => true,
		'bank_transfer_charge' => true,
		'booking_verified' => true,
        'customer' => true,
        'beverage_item_orders' => true,
        'booking_payments' => true,
        'food_item_orders' => true,
        'housekeeping_orders' => true
    ];
}
