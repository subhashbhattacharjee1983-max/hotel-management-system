<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FoodItemOrder Entity
 *
 * @property int $id
 * @property int $booking_id
 * @property int $admin_id
 * @property string $order_type
 * @property string|null $table_number
 * @property string|null $guest_name
 * @property string|null $mobile_number
 * @property int|null $number_of_persion
 * @property \Cake\I18n\FrozenDate|null $from_date
 * @property \Cake\I18n\FrozenDate|null $to_date
 * @property string|null $special_note
 * @property string|null $room_number
 * @property float $food_item_price
 * @property int $total_quantity
 * @property int $total_no_of_days
 * @property float $sub_total 
 * @property string $is_payment
 * @property string|null $payment_method
 * @property \Cake\I18n\FrozenDate|null $order_date
 * @property string|null $booked_by
 * @property string $is_delivered
 * @property string $status
 *
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\Admin $admin
 * @property \App\Model\Entity\FoodItemDetail[] $food_item_details
 */
class FoodItemOrder extends Entity
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
        'admin_id' => true,
        'order_type' => true,
        'table_number' => true,
        'guest_name' => true,
        'mobile_number' => true,
        'number_of_persion' => true,
		'from_date' => true,
		'to_date' => true,
        'special_note' => true,
        'room_number' => true,
		'food_item_price' => true,
		'total_quantity' => true,
		'total_no_of_days' => true,
        'sub_total' => true,        
        'is_payment' => true,
        'payment_method' => true,
        'order_date' => true,
		'booked_by' => true,
		'is_delivered' => true,
        'status' => true,
        'booking' => true,
        'admin' => true,
        'food_item_details' => true
    ];
}
