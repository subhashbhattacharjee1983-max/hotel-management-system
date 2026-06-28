<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $validImageFormats=array("jpg", "gif", "png", "jpeg", "pdf", "JPG", "GIF", "PNG", "JPEG", "PDF");
    public $status = array('Y' => 'Active', 'N' => 'Inactive');
	public $tax_allow = array('Y' => 'Yes', 'N' => 'No');
	public $order_type = array('R' => 'Room', 'T' => 'Table', 'E' => 'Conference / Event', 'C' => 'Catering');
	public $booking_type = array('B' => 'Booking');
	public $reservation_type = array('R' => 'Reservation');
	public $food_plan = array('No' => 'No', 'Veg' => 'Veg', 'Non-Veg' => 'Non-Veg');
	public $booking_package = array('Room Only' => 'Room Only', 'Room With Breakfirst' => 'Room With Breakfirst', 'Room with Breakfast & Dinner' => 'Room with Breakfast & Dinner', 'Room with Breakfast & Lunch' => 'Room with Breakfast & Lunch', 'Room With Any Heavy Food (Lunch / Dinner)' => 'Room With Any Heavy Food (Lunch / Dinner)', 'Room With Full Meal' => 'Room With Full Meal');
	public $access_menu = array('1' => 'Dashboard', '2' => 'Room Management', '3' => 'Room Service', '4' => 'Booking', '5' => 'Reservation', '6' => 'Food & Kitchen', '7' => 'Beverage & Bar', '8' => 'Customer', '9' => 'Report', '10' => 'Settings');
	public $food_order_status = array('Y' => 'Completed', 'N' => 'Pending');
	public $account_type = array('1' => 'Super Admin', '2' => 'Reception', '3' => 'Assistant Reception', '4' => 'Beverage Staff', '5' => 'Food Staff', '6' => 'House Keeping', '7' => 'Manager', '8' => 'Accounts');
	public $booking_status = array('C' => 'Confirmed', 'O' => 'Checked Out');
	public $payment_status = array('P' => 'Paid', 'U' => 'Unpaid', 'R' => 'Partial');
	public $bill_type = array('RB' => 'Room Bill', 'FB' => 'Food (KOT) Bill', 'BB' => 'Beverage (BOT) Bill', 'SB' => 'Service Bill', 'AD' => 'Advance', 'LS' => 'Lump Sum', 'Final' => 'Final', 'Other' => 'Other');
	public $payment_method = array('Bank' => 'Bank', 'M-BOB' => 'M-BOB', 'Cash' => 'Cash', 'UPI' => 'UPI', 'Card' => 'Card', 'Other' => 'Other');
	public $room_status = array('A' => 'Available', 'O' => 'Occupied', 'M' => 'Maintenance');
	public $id_type = array('Citizenship' => 'Citizenship', 'Voter ID' => 'Voter ID', 'Aadhaar Card' => 'Aadhaar Card', 'Passport' => 'Passport', 'Driving License' => 'Driving License', 'Other' => 'Other');
	public $guest_category = array('Normal / Local' => 'Normal / Local', 'Indian' => 'Indian', 'Indian via Agent' => 'Indian via Agent', 'International via Agent' => 'International via Agent', 'Company' => 'Company');
	public $currency = array('₹'=>'₹', 'Nu.'=>'Nu.', '₨'=>'₨', '€'=>'€', '$'=>'$');
	public $upload_folder = 'hotel';
	public $website_logo_folder = 'logo_folder';
	public $option = array('' => 'Show Data', 50 => 50, 75 => 75, 100 => 100);
	public $start_page = "100";
	public $website_name = 'Hotel Management System';

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

		$this->viewBuilder()->setLayout('admin_default');
		$this->loadComponent('Auth', [
			'loginAction' => [
				'controller' => 'Admins',
				'action' => 'login'
			],
			'loginRedirect' => [
				'controller' => 'Bookings',
				'action' => 'dashboard'
			],
			'logoutRedirect' => [
				'controller' => 'Admins',
				'action' => 'login'
			],
			'authError' => 'Did you really think you are allowed to see that?',
			'authenticate' => [
				'Form' => [
					'fields' => [
						'username' => 'email',
						'password' => 'password'
					],
					'userModel' => 'Admins'/*,
					'scope' => [
						'account_type' => 'S'
					],*/
				]
			],
			'storage' => 'Session',
			'unauthorizedRedirect' => false
		]);
		if ($this->Auth->user() && !isset($this->Auth->user()['admin'])) {
			return $this->redirect(['controller' => 'Admins', 'action' => 'login', 'prefix' => false, 'admin' => false]);
			exit;
		}
    }

	public function beforeFilter(Event $event)
	{
		$this->Auth->getConfig('authenticate', [
			'Form' => ['userModel' => 'Admins']
		]); 
		$this->Auth->allow(['login', 'forgot', 'termCondition', 'privacyPolicy']);
	}

	public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->getType(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

		$this->_setErrorLayout();
		$this->set('upload_folder', $this->upload_folder);
		$this->set('order_type', $this->order_type);
		$this->set('booking_type', $this->booking_type);
		$this->set('reservation_type', $this->reservation_type);
		$this->set('booking_package', $this->booking_package);
		$this->set('food_plan', $this->food_plan);
		$this->set('access_menu', $this->access_menu);		
		$this->set('food_order_status', $this->food_order_status);
		$this->set('payment_status', $this->payment_status);
		$this->set('bill_type', $this->bill_type);
		$this->set('payment_method', $this->payment_method);
		$this->set('website_logo_folder', $this->website_logo_folder);
		$this->set('website_name', $this->website_name);
		$this->set('option', $this->option);
		$this->set('status', $this->status);
		$this->set('tax_allow', $this->tax_allow);
		$this->set('account_type', $this->account_type);
		$this->set('booking_status', $this->booking_status);		
		$this->set('id_type', $this->id_type);
		$this->set('room_status', $this->room_status);
		$this->set('guest_category', $this->guest_category);
		$this->set('currency', $this->currency);
		$this->site_general_settings();
	}

	function _setErrorLayout() {
		if ($this->name == 'CakeError') { 
			$this->layout = '404';
		}
	}

	function Send_HTML_Mail($mail_To, $mail_From, $mail_CC, $mail_subject, $mail_Body, $mail_Reply=null, $mail_BCC=null){
		$mail_Headers  = "MIME-Version: 1.0\r\n";
		$mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
		$mail_Headers .= "From: ${mail_From}\r\n";
		if($mail_CC != ''){
			$mail_Headers .= "CC: ${mail_CC}\r\n";
		}
		if($mail_BCC != ''){
			$mail_Headers .= "BCC: ${mail_BCC}\r\n";
		}
		if($mail_Reply!=null){
			$mail_Headers .= "Reply-To: ${mail_Reply}\r\n";
		}
		if(mail($mail_To, $mail_subject, $mail_Body, $mail_Headers)){	
			return true;
		}else{        	
			return false;
		}
	}

	public function payment_for_booking($booking_id = null){
		$this->loadModel('Bookings');
		$this->loadModel('BookingPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
		$this->loadModel('Settings');
		if(isset($booking_id) && $booking_id!="")
		{
			$setting = $this->Settings->find('all', ['conditions' => []])->first();
			$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
			
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
			$remaining_amount = round($grand_total_booking_amount - $total_booking_payments);
			return $remaining_amount;
		}
	}

	public function payment_for_item_order($order_payment_id = null, $table_type = null){
		$this->loadModel('OrderItemPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('Settings');
		if(isset($order_payment_id) && $order_payment_id!="" && isset($table_type) && $table_type!="")
		{
			$setting = $this->Settings->find('all', ['conditions' => []])->first();
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			if($table_type == "F")
			{
				$food_order_price = $this->FoodItemOrders->find('all' , array('conditions' => array("FoodItemOrders.id" => $order_payment_id)))->first();
				$sum_payment_price = 0;
				if($food_order_price->sub_total!=""){
					$sum_payment_price = round($food_order_price->sub_total);
				}
				$bst_tax = round(($sum_payment_price * $setting->food_bst_tax)/100);
				$service_tax = round(($sum_payment_price * $setting->food_service_tax)/100);
				$gst_tax = round(($sum_payment_price * $setting->food_gst_tax)/100);
			}
			if($table_type == "B")
			{
				$baverage_order_price = $this->BeverageItemOrders->find('all' , array('conditions' => array("BeverageItemOrders.id" => $order_payment_id)))->first();
				$sum_payment_price = 0;
				if($baverage_order_price->sub_total!=""){
					$sum_payment_price = round($baverage_order_price->sub_total);
				}
				$bst_tax = round(($sum_payment_price * $setting->bar_bst_tax)/100);
				$service_tax = round(($sum_payment_price * $setting->bar_service_tax)/100);
				$gst_tax = round(($sum_payment_price * $setting->bar_gst_tax)/100);
			}
			$grand_payment_price = $sum_payment_price + $bst_tax + $service_tax + $gst_tax;
			return round($grand_payment_price);
		}
	}

	public function food_order_total_amount_generate($booking_id = null){
		$this->loadModel('FoodItemOrders');
		$food_item_order_price = $this->FoodItemOrders->find('all' , array('fields' => ['total_food_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("FoodItemOrders.booking_id" => $booking_id, 'FoodItemOrders.is_payment' => "P", 'FoodItemOrders.is_delivered' => "Y")))->first();
		$total_food_item_order_price = 0;
		if($food_item_order_price->total_food_item_order_price!=""){
			$total_food_item_order_price = $food_item_order_price->total_food_item_order_price;
		}
		return round($total_food_item_order_price);
	}

	public function bar_order_total_amount_generate($booking_id = null){
		$this->loadModel('BeverageItemOrders');
		$bavarage_item_order_price = $this->BeverageItemOrders->find('all' , array('fields' => ['total_bavarage_item_order_price' => 'SUM(sub_total)'], 'conditions' => array("BeverageItemOrders.booking_id" => $booking_id, 'BeverageItemOrders.is_payment' => "P", 'BeverageItemOrders.is_delivered' => "Y")))->first();
		$total_bavarage_item_order_price = 0;
		if($bavarage_item_order_price->total_bavarage_item_order_price!=""){
			$total_bavarage_item_order_price = $bavarage_item_order_price->total_bavarage_item_order_price;
		}
		return round($total_bavarage_item_order_price);
	}

	public function show_rooms_generate($booking_id = null){
		$this->loadModel('BookingRoomDetails');
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

	public function booking_customer_details_generate($booking_id = null){
		$this->loadModel('Bookings');
		if(isset($booking_id) && $booking_id!=""){
			$booking = $this->Bookings->find('all', ['contain' => ['Customers'], 'conditions' => ['Bookings.id' => $booking_id]])->first();
		}
		return $booking;
	}

	public function final_tally_summery_generate($booking_id = null){
		$this->loadModel('Bookings');
		$this->loadModel('BookingPayments');
		$this->loadModel('FoodItemOrders');
		$this->loadModel('BeverageItemOrders');
		$this->loadModel('HousekeepingOrders');
		$this->loadModel('Settings');
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

	public function total_room_occupancy_generate($room_number = null, $start_date = null, $end_date = null){
		$this->loadModel('Bookings');
		$this->loadModel('BookingRoomDetails');
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
	
	public function limit_access($id = null){
		$limit_access = $this->request->getSession()->read('Auth.User.limit_access');
		if(in_array($id, explode(',',$limit_access))) 
		{
		}
		else
		{
			$this->Flash->error(__('You are not autorised to access this'));
			return $this->redirect(['controller'=>'Admins', 'action'=>'edit_profile']);
		}
	}

	public function house_keeping_total_amount_generate($booking_id = null){
		$this->loadModel('HousekeepingOrders');
		$house_keeping_order_price = $this->HousekeepingOrders->find('all' , array('fields' => ['total_house_keeping_order_price' => 'SUM(sub_total)'], 'conditions' => array("HousekeepingOrders.booking_id" => $booking_id)))->first();
		$total_house_keeping_order_price = 0;
		if($house_keeping_order_price->total_house_keeping_order_price!=""){
			$total_house_keeping_order_price = $house_keeping_order_price->total_house_keeping_order_price;
		}
		return round($total_house_keeping_order_price);
	}

	public function site_general_settings(){
       $this->loadModel('Settings');
	   $site_general_settings = $this->Settings->find('all', ['conditions' => []])->first();
	   $this->set('site_general_settings', $site_general_settings);	   
    }
}
