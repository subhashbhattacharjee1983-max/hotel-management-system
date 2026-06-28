<?php
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\ORM\TableRegistry;
class CommonHelper extends Helper 
{
	function entry_date($date=null){
		return date("d/m/Y",strtotime($date));
	}

	function food_item_details($order_id = null){
		$this->FoodItemDetails = TableRegistry::get('FoodItemDetails');			
		$foodItemDetails = $this->FoodItemDetails->find('all',array('conditions'=>array('FoodItemDetails.food_item_order_id' => $order_id)))->toArray();
		return $foodItemDetails;
	}

	function beverage_item_details($order_id = null){
		$this->BeverageItemDetails = TableRegistry::get('BeverageItemDetails');			
		$beverageItemDetails = $this->BeverageItemDetails->find('all',array('conditions'=>array('BeverageItemDetails.beverage_item_order_id' => $order_id)))->toArray();
		return $beverageItemDetails;
	}

	function room_booking_payment($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id, "BookingPayments.bill_type" => "RB")))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = $booking_payments->total_booking_payments;
			}
			return round($total_booking_payments);
		}
	}

	function food_booking_payment($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id, "BookingPayments.bill_type" => "FB")))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = $booking_payments->total_booking_payments;
			}
			return round($total_booking_payments);
		}
	}

	function booking_customer_details($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
		}
		return $booking;
	}

	function bar_booking_payment($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id, "BookingPayments.bill_type" => "BB")))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = $booking_payments->total_booking_payments;
			}
			return round($total_booking_payments);
		}
	}

	function food_order_total_amount($booking_id = null){
		$this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_payment' => "P", 'FoodItemOrders.is_delivered' => "Y")))->first();
		$total_food_item_order_price = 0;
		if($food_item_order_price->total_food_item_order_price!=""){
			$total_food_item_order_price = $food_item_order_price->total_food_item_order_price;
		}
		return round($total_food_item_order_price);
	}

	function bar_order_total_amount($booking_id = null){
		$this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_payment' => "P", 'BeverageItemOrders.is_delivered' => "Y")))->first();
		$total_bavarage_item_order_price = 0;
		if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
			$total_bavarage_item_order_price = $bavarage_item_order_price->total_bavarage_item_order_price;
		}
		return round($total_bavarage_item_order_price);
	}

	function house_keeping_total_amount($booking_id = null){
		$this->HousekeepingOrders = TableRegistry::get('HousekeepingOrders');
		$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
		$total_house_keeping_order_price = 0;
		if($house_keeping_order_price->total_house_keeping_order_price!=""){
			$total_house_keeping_order_price = $house_keeping_order_price->total_house_keeping_order_price;
		}
		return round($total_house_keeping_order_price);
	}

	function show_rooms($booking_id = null){
		$this->BookingRoomDetails = TableRegistry::get('BookingRoomDetails');
		$bookingRoomDetails = $this->BookingRoomDetails->find('all', ['conditions' => ["BookingRoomDetails.booking_id" => $booking_id], 'order'=>'BookingRoomDetails.id ASC'])->toArray();
		if(!empty($bookingRoomDetails))
		{
			$booking_room_name = "";
			foreach($bookingRoomDetails as $val)
			{
				$booking_room_name .= $val->booking_room_name.", ";
			}
			return rtrim($booking_room_name,", ");
		}
	}

	function show_reservation_rooms($reservation_id = null){
		$this->ReservationRoomDetails = TableRegistry::get('ReservationRoomDetails');
		$reservationRoomDetails = $this->ReservationRoomDetails->find('all', ['conditions' => ["ReservationRoomDetails.reservation_id" => $reservation_id], 'order'=>'ReservationRoomDetails.id ASC'])->toArray();
		if(!empty($reservationRoomDetails))
		{
			$reservation_room_number = "";
			foreach($reservationRoomDetails as $val)
			{
				$reservation_room_number .= $val->reservation_room_number.", ";
			}
			return rtrim($reservation_room_number,", ");
		}
	}

	function booking_payment($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		$this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		$this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		$this->HousekeepingOrders = TableRegistry::get('HousekeepingOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_price = $this->Bookings->find('all' , array('fields' => ['total_booking_price' => 'SUM(booking_price)'], 'conditions' => array("Bookings.id" => $booking_id)))->first();
			$total_booking_price = 0;
			if($booking_price->total_booking_price!=""){
				$total_booking_price = round($booking_price->total_booking_price) * $booking->number_of_night;
			}
			$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_delivered' => "Y")))->first();
			$total_food_item_order_price = 0;
			if($food_item_order_price->total_food_item_order_price!=""){
				$total_food_item_order_price = round($food_item_order_price->total_food_item_order_price);
			}
			$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_delivered' => "Y")))->first();
			$total_bavarage_item_order_price = 0;
			if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
				$total_bavarage_item_order_price = round($bavarage_item_order_price->total_bavarage_item_order_price);
			}
			$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
			$total_house_keeping_order_price = 0;
			if($house_keeping_order_price->total_house_keeping_order_price!=""){
				$total_house_keeping_order_price = round($house_keeping_order_price->total_house_keeping_order_price);
			}
			$total_booking_amount = $total_booking_price + $total_food_item_order_price + $total_bavarage_item_order_price + $total_house_keeping_order_price;
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			$bank_transfer_charge = 0;
			
			/*if($total_food_item_order_price > 0 || $total_bavarage_item_order_price > 0 || $total_house_keeping_order_price > 0)
			{
				$bst_tax = round(($total_booking_amount * $setting->bst_tax)/100);
				$service_tax = round(($total_booking_amount * $setting->service_tax)/100);
				$gst_tax = round(($total_booking_amount * $setting->gst_tax)/100);
			}
			else
			{*/
				if($booking->allow_bst == "Y")
				{
					$bst_tax = round(($total_booking_amount * $booking->bst_tax)/100);
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = round(($total_booking_amount * $booking->service_tax)/100);
				}
				if($booking->allow_gst == "Y")
				{
					$gst_tax = round(($total_booking_amount * $booking->gst_tax)/100);
				}
				if($booking->allow_bank_transfer_charge == "Y")
				{
					$bank_transfer_charge = $booking->bank_transfer_charge;
				}
			//}			
			$grand_total_booking_amount = $total_booking_amount + $bst_tax + $service_tax + $gst_tax + $bank_transfer_charge;
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id)))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = round($booking_payments->total_booking_payments);
			}
			$remaining_amount = $grand_total_booking_amount - $total_booking_payments;

			$show_payment = '
							<label style="padding: 5px 15px; background: #5bc0de; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Room Booking Amount: '.$setting->currency.round($total_booking_price).'
							</label> <br />';
							if($total_food_item_order_price > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f2994b; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Food (KOT): '.$setting->currency.round($total_food_item_order_price).'
							</label> <br />';
							}
							if($total_bavarage_item_order_price > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #5cb85c; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Beverage (BOT): '.$setting->currency.round($total_bavarage_item_order_price).'
							</label> <br />';
							}
							if($total_house_keeping_order_price > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f2994b; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								House Keeping / Service: '.$setting->currency.round($total_house_keeping_order_price).'
							</label> <br />';
							}
			$show_payment .= '<label style="padding: 5px 15px; background: #e9662c; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Total Booking Amount: '.$setting->currency.round($total_booking_amount).'
							</label> <br />';
							if($bst_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f0ad4e; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								BST ('.$booking->bst_tax.'%): '.$setting->currency.round($bst_tax).'
							</label> <br />';
							}
							if($service_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #5cb85c; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Service Charge ('.$booking->service_tax.'%): '.$setting->currency.round($service_tax).'
							</label> <br />';
							}
							if($gst_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f0ad4e; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								GST ('.$booking->gst_tax.'%): '.$setting->currency.round($gst_tax).'
							</label> <br />';
							}
			                if($bank_transfer_charge > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f0ad4e; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Bank Transfer Charge: '.$setting->currency.round($bank_transfer_charge).'
							</label> <br />';
							}
			$show_payment .= '<label style="padding: 5px 15px; background: #bf3773; width: 100%; border-radius: 7px; font-size: 17px; color: #FFF;" for="inputName" class="control-label">
								Grand Total Amount: '.$setting->currency.round($grand_total_booking_amount).'
							</label> <br />
							<label style="padding: 5px 15px; background: #0a819c; width: 100%; border-radius: 7px; font-size: 17px; color: #FFF;" for="inputName" class="control-label">
								Total Payment: '.$setting->currency.round($total_booking_payments).'
							</label> <br />
							<label style="padding: 5px 15px; background: #bf4346; width: 100%; border-radius: 7px; font-size: 17px; color: #FFF;" for="inputName" class="control-label">
								Balance Due: '.$setting->currency.round($remaining_amount).'
							</label>';
			return $show_payment;
		}
	}

	function order_item_payment($order_payment_id = null, $table_type = null){
		$this->OrderItemPayments = TableRegistry::get('OrderItemPayments');
		$this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		$this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		$this->Settings = TableRegistry::get('Settings');
		if(isset($order_payment_id) && $order_payment_id!="" && isset($table_type) && $table_type!="")
		{
			$setting = $this->Settings->find('all', ['conditions' => []])->first();
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			$show_bst_tax = 0;
			$show_service_tax = 0;
			$show_gst_tax = 0;
			if($table_type == "F")
			{
				$booking_payments = $this->OrderItemPayments->find('all' , array('fields' => ['total_order_item_payments' => 'SUM(payment_price)'], 'conditions' => array("OrderItemPayments.food_item_order_id" => $order_payment_id)))->first();
				$food_order_price = $this->FoodItemOrders->find('all' , array('conditions' => array("FoodItemOrders.id" => $order_payment_id)))->first();
				$sum_payment_price = 0;
				if($food_order_price->sub_total!=""){
					$sum_payment_price = round($food_order_price->sub_total);
				}
				$bst_tax = round(($sum_payment_price * $setting->food_bst_tax)/100);
				$service_tax = round(($sum_payment_price * $setting->food_service_tax)/100);
				$gst_tax = round(($sum_payment_price * $setting->food_gst_tax)/100);
				$show_bst_tax = $setting->food_bst_tax;
				$show_service_tax = $setting->food_service_tax;
				$show_gst_tax = $setting->food_gst_tax;
			}
			if($table_type == "B")
			{
				$booking_payments = $this->OrderItemPayments->find('all' , array('fields' => ['total_order_item_payments' => 'SUM(payment_price)'], 'conditions' => array("OrderItemPayments.beverage_item_order_id" => $order_payment_id)))->first();
				$baverage_order_price = $this->BeverageItemOrders->find('all' , array('conditions' => array("BeverageItemOrders.id" => $order_payment_id)))->first();
				$sum_payment_price = 0;
				if($baverage_order_price->sub_total!=""){
					$sum_payment_price = round($baverage_order_price->sub_total);
				}
				$bst_tax = round(($sum_payment_price * $setting->bar_bst_tax)/100);
				$service_tax = round(($sum_payment_price * $setting->bar_service_tax)/100);
				$gst_tax = round(($sum_payment_price * $setting->bar_gst_tax)/100);
				$show_bst_tax = $setting->bar_bst_tax;
				$show_service_tax = $setting->bar_service_tax;
				$show_gst_tax = $setting->bar_gst_tax;
			}
			
			$grand_payment_price = $sum_payment_price + $bst_tax + $service_tax + $gst_tax;
			
			
			$total_order_item_payments = 0;
			if($booking_payments->total_order_item_payments!=""){
				$total_order_item_payments = round($booking_payments->total_order_item_payments);
			}
			$remaining_amount = $grand_payment_price - $total_order_item_payments;

			$show_payment = '
							<label style="padding: 5px 15px; background: #5bc0de; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Order Amount: '.$setting->currency.round($sum_payment_price).'
							</label> <br />';
							if($bst_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f0ad4e; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								BST ('.$show_bst_tax.'%): '.$setting->currency.round($bst_tax).'
							</label> <br />';
							}
							if($service_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #5cb85c; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								Service Charge ('.$show_service_tax.'%): '.$setting->currency.round($service_tax).'
							</label> <br />';
							}
							if($gst_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f0ad4e; width: 100%; border-radius: 7px; color: #FFF;" for="inputName" class="control-label">
								GST ('.$show_gst_tax.'%): '.$setting->currency.round($gst_tax).'
							</label> <br />';
							}
			$show_payment .= '<label style="padding: 5px 15px; background: #bf3773; width: 100%; border-radius: 7px; font-size: 17px; color: #FFF;" for="inputName" class="control-label">
								Grand Total Amount: '.$setting->currency.round($grand_payment_price).'
							</label> <br />
							<label style="padding: 5px 15px; background: #0a819c; width: 100%; border-radius: 7px; font-size: 17px; color: #FFF;" for="inputName" class="control-label">
								Total Payment: '.$setting->currency.round($total_order_item_payments).'
							</label> <br />
							<label style="padding: 5px 15px; background: #bf4346; width: 100%; border-radius: 7px; font-size: 17px; color: #FFF;" for="inputName" class="control-label">
								Balance Due: '.$setting->currency.round($remaining_amount).'
							</label>';
			return $show_payment;
		}
	}

	function booking_payment_for_reservation($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		$this->RefundPayments = TableRegistry::get('RefundPayments');
		$this->Settings = TableRegistry::get('Settings');
		if(isset($booking_id) && $booking_id!="")
		{
			$setting = $this->Settings->find('all', ['conditions' => []])->first();
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_price = $this->Bookings->find('all' , array('fields' => ['total_booking_price' => 'SUM(booking_price)'], 'conditions' => array("Bookings.id" => $booking_id)))->first();
			$total_booking_price = 0;
			if($booking_price->total_booking_price!=""){
				$total_booking_price = round($booking_price->total_booking_price) * $booking->number_of_night;
			}
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id)))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = round($booking_payments->total_booking_payments);
			}

			$show_payment = '
							<label style="padding: 5px 15px; background: #5bc0de; width: 100%; color: #FFF;" for="inputName" class="control-label">
								Order Amount: '.$setting->currency.round($total_booking_price).'
							</label> <br />
							<label style="padding: 5px 15px; background: #0a819c; width: 100%; font-size: 17px; color: #FFF;" for="inputName" class="control-label">
								Total Payment: '.$setting->currency.round($total_booking_payments).'
							</label>';
			return $show_payment;
		}
	}

	function verify_booking_debit($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		$this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		$this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		$this->HousekeepingOrders = TableRegistry::get('HousekeepingOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_price = $this->Bookings->find('all' , array('fields' => ['total_booking_price' => 'SUM(booking_price)'], 'conditions' => array("Bookings.id" => $booking_id)))->first();
			$total_booking_price = 0;
			if($booking_price->total_booking_price!=""){
				$total_booking_price = round($booking_price->total_booking_price) * $booking->number_of_night;
			}
			$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_delivered' => "Y")))->first();
			$total_food_item_order_price = 0;
			if($food_item_order_price->total_food_item_order_price!=""){
				$total_food_item_order_price = round($food_item_order_price->total_food_item_order_price);
			}
			$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_delivered' => "Y")))->first();
			$total_bavarage_item_order_price = 0;
			if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
				$total_bavarage_item_order_price = round($bavarage_item_order_price->total_bavarage_item_order_price);
			}
			$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
			$total_house_keeping_order_price = 0;
			if($house_keeping_order_price->total_house_keeping_order_price!=""){
				$total_house_keeping_order_price = round($house_keeping_order_price->total_house_keeping_order_price);
			}
			$total_booking_amount = $total_booking_price + $total_food_item_order_price + $total_bavarage_item_order_price + $total_house_keeping_order_price;
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			$bank_transfer_charge = 0;
			
			/*if($total_food_item_order_price > 0 || $total_bavarage_item_order_price > 0 || $total_house_keeping_order_price > 0)
			{
				$bst_tax = round(($total_booking_amount * $setting->bst_tax)/100);
				$service_tax = round(($total_booking_amount * $setting->service_tax)/100);
				$gst_tax = round(($total_booking_amount * $setting->gst_tax)/100);
			}
			else
			{*/
				if($booking->allow_bst == "Y")
				{
					$bst_tax = round(($total_booking_amount * $booking->bst_tax)/100);
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = round(($total_booking_amount * $booking->service_tax)/100);
				}
				if($booking->allow_gst == "Y")
				{
					$gst_tax = round(($total_booking_amount * $booking->gst_tax)/100);
				}
				if($booking->allow_bank_transfer_charge == "Y")
				{
					$bank_transfer_charge = $booking->bank_transfer_charge;
				}
			//}			
			$grand_total_booking_amount = $total_booking_amount + $bst_tax + $service_tax + $gst_tax + $bank_transfer_charge;
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id)))->first();

			$show_payment = '
							<label style="padding: 5px 15px; background: #f8d7da; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								Room Booking Amount: '.$setting->currency.round($total_booking_price).' <a href="'.$setting->site_url."bookings/view/".$booking_id.'#room" target="_blank"><img src="'.$setting->site_url.'img/icons/view.png"></a>
							</label> <br />';
							if($total_food_item_order_price > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #dee2e6; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								Food (KOT): '.$setting->currency.round($total_food_item_order_price).' <a href="'.$setting->site_url."bookings/view/".$booking_id.'#food" target="_blank"><img src="'.$setting->site_url.'img/icons/view.png"></a>
							</label> <br />';
							}
							if($total_bavarage_item_order_price > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #c5d7f2; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								Beverage (BOT): '.$setting->currency.round($total_bavarage_item_order_price).' <a href="'.$setting->site_url."bookings/view/".$booking_id.'#bar" target="_blank"><img src="'.$setting->site_url.'img/icons/view.png"></a>
							</label> <br />';
							}
							if($total_house_keeping_order_price > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #dee2e6; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								House Keeping / Service: '.$setting->currency.round($total_house_keeping_order_price).' <a href="'.$setting->site_url."bookings/view/".$booking_id.'#service" target="_blank"><img src="'.$setting->site_url.'img/icons/view.png"></a>
							</label> <br />';
							}
			$show_payment .= '<label style="padding: 5px 15px; background: #d7d8da; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								Total Booking Amount: '.$setting->currency.round($total_booking_amount).'
							</label> <br />';
							if($bst_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #c5d7f2; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								BST ('.$booking->bst_tax.'%): '.$setting->currency.round($bst_tax).'
							</label> <br />';
							}
							if($service_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #f8d7da; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								Service Charge ('.$booking->service_tax.'%): '.$setting->currency.round($service_tax).'
							</label> <br />';
							}
							if($gst_tax > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #c5d7f2; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								GST ('.$booking->gst_tax.'%): '.$setting->currency.round($gst_tax).'
							</label> <br />';
							}
							if($bank_transfer_charge > 0){
			$show_payment .= '<label style="padding: 5px 15px; background: #c5d7f2; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								Bank Transfer Charge: '.$setting->currency.round($bank_transfer_charge).'
							</label> <br />';
							}
			$show_payment .= '<label style="padding: 5px 15px; background: #d7d8da; font-weight: bold; width: 100%; border-radius: 7px; font-size: 17px; color: #000;" for="inputName" class="control-label">
								Total Bill Amount: '.$setting->currency.round($grand_total_booking_amount).'
							</label>';
			return $show_payment;
		}
	}

	function masterbill_payment($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$bill_type = array('RB' => 'Room Bill', 'FB' => 'Food (KOT) Bill', 'BB' => 'Beverage (BOT) Bill', 'SB' => 'Service Bill', 'AD' => 'Advance', 'LS' => 'Lump Sum', 'Final' => 'Final', 'Other' => 'Other');
		$payment_method = array('Bank' => 'Bank', 'M-BOB' => 'M-BOB', 'Cash' => 'Cash', 'UPI' => 'UPI', 'Card' => 'Card', 'Other' => 'Other');
		$bookingPayments = $this->BookingPayments->find('all', ['contain' => ['Bookings'], 'conditions' => ['BookingPayments.booking_id' => $booking_id], 'order'=>'BookingPayments.id DESC'])->toArray();
		$show_payment = '';
		if(!empty($bookingPayments))
		{
			$grand_payment = 0;

			$show_payment .= '<table class="summary-table" style="margin: 10px 0 0 0;">
                <thead>
                    <tr>
                        <th style="width: 40%;">Bill Type</th>
                        <th style="width: 15%;">Method</th>
                        <th style="width: 15%;">Amount</th>
                        <th style="width: 15%;">Date</th>
                    </tr>
                </thead>
                <tbody>';
						foreach($bookingPayments as $key => $val)
						{
							$grand_payment += $val->payment_price;
            $show_payment .= '<tr>
                        <td><i class="fas fa-bed"></i> '.$bill_type[$val->bill_type].'</td>
                        <td class="amount">'.$payment_method[$val->payment_method].'</td>
                        <td class="amount">'.$setting->currency.round($val->payment_price).'</td>
                        <td class="amount">'.date("d/m/Y",strtotime($val->payment_date)).'</td>                        
                    </tr>';
						}

             $show_payment .= '<tr class="total-row">
                        <td>
                            <strong><i class="fas fa-calculator"></i> TOTAL PAYMENT</strong>
                        </td>
                        <td colspan="3" class="amount"><strong>'.$setting->currency.round($grand_payment).'</strong></td>
                    </tr>
                </tbody>
            </table>';	
			
			return $show_payment;
		}		
	}

	function master_bill_receipt_debit($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		$this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		$this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		$this->HousekeepingOrders = TableRegistry::get('HousekeepingOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_price = $this->Bookings->find('all' , array('fields' => ['total_booking_price' => 'SUM(booking_price)'], 'conditions' => array("Bookings.id" => $booking_id)))->first();
			$total_booking_price = 0;
			if($booking_price->total_booking_price!=""){
				$total_booking_price = round($booking_price->total_booking_price) * $booking->number_of_night;
			}
			$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_delivered' => "Y")))->first();
			$total_food_item_order_price = 0;
			if($food_item_order_price->total_food_item_order_price!=""){
				$total_food_item_order_price = round($food_item_order_price->total_food_item_order_price);
			}
			$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_delivered' => "Y")))->first();
			$total_bavarage_item_order_price = 0;
			if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
				$total_bavarage_item_order_price = round($bavarage_item_order_price->total_bavarage_item_order_price);
			}
			$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
			$total_house_keeping_order_price = 0;
			if($house_keeping_order_price->total_house_keeping_order_price!=""){
				$total_house_keeping_order_price = round($house_keeping_order_price->total_house_keeping_order_price);
			}
			$total_booking_amount = $total_booking_price + $total_food_item_order_price + $total_bavarage_item_order_price + $total_house_keeping_order_price;
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			$bank_transfer_charge = 0;
			
			/*if($total_food_item_order_price > 0 || $total_bavarage_item_order_price > 0 || $total_house_keeping_order_price > 0)
			{
				$bst_tax = round(($total_booking_amount * $setting->bst_tax)/100);
				$service_tax = round(($total_booking_amount * $setting->service_tax)/100);
				$gst_tax = round(($total_booking_amount * $setting->gst_tax)/100);
			}
			else
			{*/
				if($booking->allow_bst == "Y")
				{
					$bst_tax = round(($total_booking_amount * $booking->bst_tax)/100);
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = round(($total_booking_amount * $booking->service_tax)/100);
				}
				if($booking->allow_gst == "Y")
				{
					$gst_tax = round(($total_booking_amount * $booking->gst_tax)/100);
				}
				if($booking->allow_bank_transfer_charge == "Y")
				{
					$bank_transfer_charge = $booking->bank_transfer_charge;
				}
			//}			
			$grand_total_booking_amount = $total_booking_amount + $bst_tax + $service_tax + $gst_tax + $bank_transfer_charge;
			//$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id)))->first();

			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id)))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = round($booking_payments->total_booking_payments);
			}
			$remaining_amount = $grand_total_booking_amount - $total_booking_payments;
			
			$show_payment = '<table class="summary-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Description</th>
                        <th style="width: 15%;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fas fa-bed"></i> Room Booking Amount</td>
                        <td class="amount">'.$setting->currency.round($total_booking_price).'</td>
                    </tr>';
					if($total_food_item_order_price > 0){
			$show_payment .= '<tr>
                        <td><i class="fas fa-bed"></i> Food (KOT)</td>
                        <td class="amount">'.$setting->currency.round($total_food_item_order_price).'</td>
                    </tr>';
						}
						if($total_bavarage_item_order_price > 0){
			$show_payment .= '<tr>
                        <td><i class="fas fa-bed"></i> Beverage (BOT)</td>
                        <td class="amount">'.$setting->currency.round($total_bavarage_item_order_price).'</td>
                    </tr>';
						}
						if($total_house_keeping_order_price > 0){
			$show_payment .= '<tr>
                        <td><i class="fas fa-bed"></i> House Keeping / Service</td>
                        <td class="amount">'.$setting->currency.round($total_house_keeping_order_price).'</td>
                    </tr>';
						}
						if($bst_tax > 0){
            $show_payment .= '<tr>
                        <td><i class="fas fa-receipt"></i> Tax (BST '.$booking->bst_tax.'%)</td>
                        <td class="amount">'.$setting->currency.round($bst_tax).'</td>
                    </tr>';
						}
					if($service_tax > 0){
			$show_payment .= '<tr>
                        <td><i class="fas fa-percentage"></i> Service Charge ('.$booking->service_tax.'%)</td>
                        <td class="amount">'.$setting->currency.round($service_tax).'</td>
                    </tr>';
						}
					if($gst_tax > 0){
			$show_payment .= '<tr>
                        <td><i class="fas fa-receipt"></i> Tax (GST '.$booking->gst_tax.'%)</td>
                        <td class="amount">'.$setting->currency.round($gst_tax).'</td>
                    </tr>';
						}
						if($bank_transfer_charge > 0){
			$show_payment .= '<tr>
                        <td><i class="fas fa-receipt"></i> Bank Transfer Charge</td>
                        <td class="amount">'.$setting->currency.round($bank_transfer_charge).'</td>
                    </tr>';
						}
            $show_payment .= '<tr class="grand-total">
                        <td>
                            <strong><i class="fas fa-calculator"></i> GRAND TOTAL</strong>
                        </td>
                        <td class="amount"><strong>'.$setting->currency.round($grand_total_booking_amount).'</strong></td>
                    </tr>
                </tbody>
            </table>';

			return $show_payment;
		}
	}

	function refund_payment($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->RefundPayments = TableRegistry::get('RefundPayments');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$bill_type = array('RB' => 'Room Bill', 'FB' => 'Food (KOT) Bill', 'BB' => 'Beverage (BOT) Bill', 'SB' => 'Service Bill', 'AD' => 'Advance', 'LS' => 'Lump Sum', 'Final' => 'Final', 'Other' => 'Other');
		$payment_method = array('Bank' => 'Bank', 'M-BOB' => 'M-BOB', 'Cash' => 'Cash', 'UPI' => 'UPI', 'Card' => 'Card', 'Other' => 'Other');
		$refundPayments = $this->RefundPayments->find('all', ['contain' => ['Bookings'], 'conditions' => ['RefundPayments.booking_id' => $booking_id], 'order'=>'RefundPayments.id DESC'])->toArray();
		$show_payment = '';
		if(!empty($refundPayments))
		{
			$grand_payment = 0;
			$show_payment .= '<table width="100%" border="1" cellspacing="0" cellpadding="0">
					<tr style="background: #0a819c;">
						<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Bill Type</th>
						<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Method</th>
						<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Amount</th>
						<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Date</th>
					</tr>';
					foreach($refundPayments as $key => $val)
					{
						$grand_payment += $val->payment_price;
						$key = $key + 1;
						$style = "#d1e7dd";
						if($key%2 == 0){
							$style = "#cff4fc";
						}
					$show_payment .= '<tr>
						<td style="padding: 9px; background: '.$style.';">
							<div class="input-icon right text-center">
								'.$bill_type[$val->bill_type].'
							</div>
						</td>																
						<td style="padding: 9px; background: '.$style.';">
							<div class="input-icon right text-center">
								'.$payment_method[$val->payment_method].'
							</div>
						</td>
						<td style="padding: 9px; background: '.$style.';">
							<div class="input-icon right text-center">
								'.$setting->currency.round($val->payment_price).'
							</div>
						</td>
						<td style="padding: 9px; background: '.$style.';">
							<div class="input-icon right text-center">
								'.date("d/m/Y",strtotime($val->payment_date)).'
							</div>
						</td>
					</tr>';
					}
					$show_payment .= '<tr>
						<td colspan="4" style="padding: 9px; font-size: 17px; background: #cff4fc;">
							<div class="input-icon right text-center">
								Refund Payment: '.$setting->currency.round($grand_payment).'
							</div>
						</td>
					</tr>';
				$show_payment .= '</table>';		
		}
		return $show_payment;
	}

	function verify_booking_payment($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		$bill_type = array('RB' => 'Room Bill', 'FB' => 'Food (KOT) Bill', 'BB' => 'Beverage (BOT) Bill', 'SB' => 'Service Bill', 'AD' => 'Advance', 'LS' => 'Lump Sum', 'Final' => 'Final', 'Other' => 'Other');
		$payment_method = array('Bank' => 'Bank', 'M-BOB' => 'M-BOB', 'Cash' => 'Cash', 'UPI' => 'UPI', 'Card' => 'Card', 'Other' => 'Other');
		$bookingPayments = $this->BookingPayments->find('all', ['contain' => ['Bookings'], 'conditions' => ['BookingPayments.booking_id' => $booking_id], 'order'=>'BookingPayments.id ASC'])->toArray();
		$show_payment = '';
		if(!empty($bookingPayments))
		{
			$grand_payment = 0;
			$show_payment .= '<table width="100%" border="1" cellspacing="0" cellpadding="0">
					<tr style="background: #0a819c;">
						<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Bill Type</th>
						<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Method</th>
						<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Amount</th>
						<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Date</th>
					</tr>';
					foreach($bookingPayments as $key => $val)
					{
						$grand_payment += $val->payment_price;
						$key = $key + 1;
						$style = "#d1e7dd";
						if($key%2 == 0){
							$style = "#cff4fc";
						}
					$show_payment .= '<tr>
						<td style="padding: 9px; text-align:center; background: '.$style.';">
							<div class="input-icon right">
								'.$bill_type[$val->bill_type].'
							</div>
						</td>																
						<td style="padding: 9px; font-weight: bold; text-align:center; background: '.$style.';">
							<div class="input-icon right">
								'.$payment_method[$val->payment_method].'
							</div>
						</td>
						<td style="padding: 9px; font-weight: bold; text-align:center; background: '.$style.';">
							<div class="input-icon right">
								'.$setting->currency.round($val->payment_price).'
							</div>
						</td>
						<td style="padding: 9px; text-align:center; background: '.$style.';">
							<div class="input-icon right">
								'.date("d/m/Y",strtotime($val->payment_date)).'
							</div>
						</td>
					</tr>';
					}
					$show_payment .= '<tr>
						<td colspan="4" style="padding: 9px; font-size: 17px; font-weight: bold; background: #cff4fc;">
							<div class="input-icon right text-center">
								Total Payments: '.$setting->currency.round($grand_payment).' <a href="'.$setting->site_url."bookings/paymentbill/".$booking_id.'" target="_blank"><img src="'.$setting->site_url.'img/icons/print.jpg"></a>
							</div>
						</td>
					</tr>';
				$show_payment .= '</table>';		
		}
		return $show_payment;
	}

	function final_tally_summery($booking_id = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingPayments = TableRegistry::get('BookingPayments');
		$this->FoodItemOrders = TableRegistry::get('FoodItemOrders');
		$this->BeverageItemOrders = TableRegistry::get('BeverageItemOrders');
		$this->HousekeepingOrders = TableRegistry::get('HousekeepingOrders');
		$this->Settings = TableRegistry::get('Settings');
		$setting = $this->Settings->find('all', ['conditions' => []])->first();
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['conditions' => ['Bookings.id' => $booking_id]])->first();
			$booking_price = $this->Bookings->find('all' , array('fields' => ['total_booking_price' => 'SUM(booking_price)'], 'conditions' => array("Bookings.id" => $booking_id)))->first();
			$total_booking_price = 0;
			if($booking_price->total_booking_price!=""){
				$total_booking_price = round($booking_price->total_booking_price) * $booking->number_of_night;
			}
			$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_delivered' => "Y")))->first();
			$total_food_item_order_price = 0;
			if($food_item_order_price->total_food_item_order_price!=""){
				$total_food_item_order_price = round($food_item_order_price->total_food_item_order_price);
			}
			$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_delivered' => "Y")))->first();
			$total_bavarage_item_order_price = 0;
			if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
				$total_bavarage_item_order_price = round($bavarage_item_order_price->total_bavarage_item_order_price);
			}
			$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
			$total_house_keeping_order_price = 0;
			if($house_keeping_order_price->total_house_keeping_order_price!=""){
				$total_house_keeping_order_price = round($house_keeping_order_price->total_house_keeping_order_price);
			}
			$total_booking_amount = $total_booking_price + $total_food_item_order_price + $total_bavarage_item_order_price + $total_house_keeping_order_price;
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			$bank_transfer_charge = 0;
			
			/*if($total_food_item_order_price > 0 || $total_bavarage_item_order_price > 0 || $total_house_keeping_order_price > 0)
			{
				$bst_tax = round(($total_booking_amount * $setting->bst_tax)/100);
				$service_tax = round(($total_booking_amount * $setting->service_tax)/100);
				$gst_tax = round(($total_booking_amount * $setting->gst_tax)/100);
			}
			else
			{*/
				if($booking->allow_bst == "Y")
				{
					$bst_tax = round(($total_booking_amount * $booking->bst_tax)/100);
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = round(($total_booking_amount * $booking->service_tax)/100);
				}
				if($booking->allow_gst == "Y")
				{
					$gst_tax = round(($total_booking_amount * $booking->gst_tax)/100);
				}
				if($booking->allow_bank_transfer_charge == "Y")
				{
					$bank_transfer_charge = $booking->bank_transfer_charge;
				}
			//}			
			$grand_total_booking_amount = $total_booking_amount + $bst_tax + $service_tax + $gst_tax + $bank_transfer_charge;
			$booking_payments = $this->BookingPayments->find('all' , array('fields' => ['total_booking_payments' => 'SUM(payment_price)'], 'conditions' => array("BookingPayments.booking_id" => $booking_id)))->first();
			$total_booking_payments = 0;
			if($booking_payments->total_booking_payments!=""){
				$total_booking_payments = $booking_payments->total_booking_payments;
			}
			$remaining_amount = $grand_total_booking_amount - $total_booking_payments;

			return round($grand_total_booking_amount)."@".round($total_booking_payments)."@".round($remaining_amount);
		}
	}

	function total_room_occupancy($room_number = null, $start_date = null, $end_date = null){
		$this->Bookings = TableRegistry::get('Bookings');
		$this->BookingRoomDetails = TableRegistry::get('BookingRoomDetails');
		if(isset($start_date) && $start_date!="")
		{
			$condition['Bookings.booking_date >='] = $start_date." 00:00:00";
		}
		if(isset($end_date) && $end_date!="")
		{
			$condition['Bookings.booking_date <='] = $end_date." 23:59:59";
		}
		$booking_master = $this->Bookings->find('all', ['conditions' => $condition, 'order' => 'Bookings.id DESC'])->toArray();
		$booking_id = [];
		$total_room = 0;
		if(!empty($booking_master)){
			foreach($booking_master as $val){
				$booking_id[] = $val->id;
			}
			$bookingRoomDetails = $this->BookingRoomDetails->find('all', ['fields' => ['total_booking_room_name' => 'COUNT(booking_room_name)'], 'conditions' => ['BookingRoomDetails.booking_id IN' => $booking_id, 'BookingRoomDetails.booking_room_name' => $room_number]])->first();
		}
		if($bookingRoomDetails->total_booking_room_name > 0){
			$total_room = $bookingRoomDetails->total_booking_room_name;
		}
		return $total_room;
	}
	
	function convert_number_to_words($number) {
	   $no = round($number);
	   $point = round(substr(strstr($number,"."),1), 2);
	   $hundred = null;
	   $digits_1 = strlen($no);
	   $i = 0;
	   $str = array();
	   $words = array('0' => '', '1' => 'one', '2' => 'two',
		'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		'7' => 'seven', '8' => 'eight', '9' => 'nine',
		'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		'13' => 'thirteen', '14' => 'fourteen',
		'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		'60' => 'sixty', '70' => 'seventy',
		'80' => 'eighty', '90' => 'ninety');
	   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
	   while ($i < $digits_1) {
		 $divider = ($i == 2) ? 10 : 100;
		 $number = floor($no % $divider);
		 $no = floor($no / $divider);
		 $i += ($divider == 10) ? 1 : 2;
		 if ($number) {
			$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			$str [] = ($number < 21) ? $words[$number] .
				" " . $digits[$counter] . $plural . " " . $hundred
				:
				$words[floor($number / 10) * 10]
				. " " . $words[$number % 10] . " "
				. $digits[$counter] . $plural . " " . $hundred;
		 } else $str[] = null;
	  }
	  $str = array_reverse($str);
	  $result = implode('', $str);
	  $points = ($point) ?
		" and " . $words[$point / 10] . " " . 
			  $words[$point = $point % 10] : '';
	  return ucwords($result . $points . " only");
	  //return ucwords($result . "Rupees  " . $points . " Paise only");
	}
}
?>